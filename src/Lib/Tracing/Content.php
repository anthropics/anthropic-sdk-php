<?php

declare(strict_types=1);

namespace Anthropic\Lib\Tracing;

use OpenTelemetry\API\Trace\SpanInterface;

/**
 * The content attributes of a span: request and response messages as the parts of the generative-AI conventions.
 * A thinking block is a reasoning part with the block's thinking and without its signature. A block other than text,
 * thinking, a tool use, or a tool's result is a part with only its type, prefixed with `anthropic_`. Image and
 * document data is left out because it is large and binary. Redacted thinking is left out because it is encrypted.
 *
 * The shapes of the generative-AI conventions that the attributes hold. Values that come from the request or the
 * response are recorded as they are.
 *
 * @phpstan-type TextPart = array{type: 'text', content: mixed}
 * @phpstan-type ToolCallPart = array{type: 'tool_call', id: mixed, name: mixed, arguments: mixed, anthropic_mcp_server_name?: mixed, anthropic_toolset_name?: string}
 * @phpstan-type ToolCallResponsePart = array{type: 'tool_call_response', id: mixed, response: array<mixed>}
 * @phpstan-type ReasoningPart = array{type: 'reasoning', content: mixed}
 * @phpstan-type OtherPart = array{type: string}
 * @phpstan-type Part = TextPart|ToolCallPart|ToolCallResponsePart|ReasoningPart|OtherPart
 * @phpstan-type InputMessage = array{role: string, parts: list<Part>}
 * @phpstan-type OutputMessage = array{role: 'assistant', parts: list<Part>}
 *
 * @internal
 */
final class Content
{
    /**
     * The most bytes that the content attributes of one span hold, as `strlen` counts them over their JSON, when
     * leaving out the stop sequences or a tool's input, and removing message parts or the content blocks of a tool's
     * result, can bring them under it. A client whose `openTelemetry` option sets `traces.maxContentBytes` has that
     * bound in its place. The SDK's own is 0.75 MB, which stays under the 1 MB that many collectors accept.
     */
    public const LIMIT = 750000;

    /**
     * Sets the content attributes of a Messages create call: the request's system prompt, stop sequences and
     * messages, and `$output`, the response's content blocks, when the response is complete. Together they hold at
     * most `$limit` bytes, as {@see self::setMessageContentAttributes()} says.
     *
     * @param array<mixed> $body the request body, in the API's shape
     * @param list<mixed>|null $output
     */
    public static function setMessageContent(SpanInterface $span, array $body, ?array $output, int $limit = self::LIMIT): void
    {
        $messages = self::wire($body['messages'] ?? null);
        $input = [];
        foreach (is_array($messages) ? $messages : [] as $message) {
            $message = self::wire($message);
            $role = is_array($message) ? ($message['role'] ?? null) : null;
            $input[] = [
                'role' => is_string($role) ? $role : 'user',
                'parts' => self::parts(is_array($message) ? ($message['content'] ?? null) : null),
            ];
        }
        $stopSequences = self::wire($body['stop_sequences'] ?? null);
        self::setMessageContentAttributes(
            $span,
            array_key_exists('system', $body) ? self::parts($body['system']) : null,
            $input,
            null === $output ? null : [['role' => 'assistant', 'parts' => self::parts($output)]],
            array_values(array_filter(is_array($stopSequences) ? $stopSequences : [], 'is_string')),
            $limit,
        );
    }

    /**
     * Sets the content attributes of a Messages create call, each serialized as one JSON string. A null value sets
     * no attribute. Throws when a value has no JSON.
     *
     * `$stopSequences` is `gen_ai.request.stop_sequences`, a list of strings and not JSON. An empty list sets no
     * attribute, and neither does one with a string that is not UTF-8, which an exporter would fail on. Its strings
     * count toward the limit. When they total more than `$limit` bytes by themselves, the attribute is left out
     * whole and counts as nothing.
     *
     * When the values then total more than `$limit` bytes, `gen_ai.system_instructions`, `gen_ai.input.messages` and
     * `gen_ai.output.messages` lose message parts until they fit, as {@see self::fit()} says. What that keeps, such
     * as an emptied list or a message without parts, can still leave a span over the limit. A span that lost
     * something, the stop sequences included, gets `anthropic.content.truncated`, and the content attributes hold no
     * marker of the removal.
     *
     * @param list<Part>|null $systemInstructions
     * @param list<InputMessage>|null $inputMessages
     * @param list<OutputMessage>|null $outputMessages
     * @param list<string> $stopSequences
     */
    public static function setMessageContentAttributes(SpanInterface $span, ?array $systemInstructions, ?array $inputMessages, ?array $outputMessages, array $stopSequences = [], int $limit = self::LIMIT): void
    {
        foreach ($stopSequences as $stopSequence) {
            if (!mb_check_encoding($stopSequence, 'UTF-8')) {
                $stopSequences = [];
            }
        }
        $truncated = array_sum(array_map('strlen', $stopSequences)) > $limit;
        if ($truncated) {
            $stopSequences = [];
        }
        $system = null === $systemInstructions ? null : self::json($systemInstructions);
        $input = null === $inputMessages ? null : self::json($inputMessages);
        $output = null === $outputMessages ? null : self::json($outputMessages);
        $size = strlen($system ?? '') + strlen($input ?? '') + strlen($output ?? '') + array_sum(array_map('strlen', $stopSequences));
        if ($size > $limit) {
            [$systemInstructions, $inputMessages, $outputMessages, $reduced] = self::fit($systemInstructions, $inputMessages, $outputMessages, $size - $limit);
            if ($reduced) {
                $system = null === $systemInstructions ? null : self::json($systemInstructions);
                $input = null === $inputMessages ? null : self::json($inputMessages);
                $output = null === $outputMessages ? null : self::json($outputMessages);
                $truncated = true;
            }
        }
        if ($truncated) {
            $span->setAttribute(TraceAttributes::ANTHROPIC_CONTENT_TRUNCATED, true);
        }

        if ([] !== $stopSequences) {
            $span->setAttribute(TraceAttributes::GEN_AI_REQUEST_STOP_SEQUENCES, $stopSequences);
        }
        if (null !== $system) {
            $span->setAttribute(TraceAttributes::GEN_AI_SYSTEM_INSTRUCTIONS, $system);
        }
        if (null !== $input) {
            $span->setAttribute(TraceAttributes::GEN_AI_INPUT_MESSAGES, $input);
        }
        if (null !== $output) {
            $span->setAttribute(TraceAttributes::GEN_AI_OUTPUT_MESSAGES, $output);
        }
    }

    /**
     * Sets the content attributes of a tool span, each serialized as one JSON string: `$input`, the tool's input, and
     * `$result`, the content blocks of the tool's result, or null for a run that made none. Throws when a value has
     * no JSON, and then sets neither.
     *
     * An input of more than `$limit` bytes by itself is left out whole, with or without a result, and the result then
     * has all of the limit. When the two then total more than `$limit` bytes, `anthropic.tool_result.content` loses
     * whole content blocks, last first, until they fit or none remains. The emptied list stays in its attribute, so
     * it can still leave a span over the limit. A span that lost its input or a block gets
     * `anthropic.content.truncated`.
     *
     * @param list<array<mixed>>|null $result
     */
    public static function setToolContentAttributes(SpanInterface $span, mixed $input, ?array $result, int $limit = self::LIMIT): void
    {
        $arguments = self::json($input);
        if (strlen($arguments) > $limit) {
            $arguments = null;
        }
        $blocks = array_map(self::json(...), $result ?? []);
        // The JSON of a list is its brackets, its elements, and a comma between each two.
        $size = strlen($arguments ?? '') + 2;
        $count = 0;
        while ($count < count($blocks) && $size + (0 === $count ? 0 : 1) + strlen($blocks[$count]) <= $limit) {
            $size += (0 === $count ? 0 : 1) + strlen($blocks[$count]);
            ++$count;
        }

        if (null !== $arguments) {
            $span->setAttribute(TraceAttributes::GEN_AI_TOOL_CALL_ARGUMENTS, $arguments);
        }
        if (null === $arguments || $count < count($blocks)) {
            $span->setAttribute(TraceAttributes::ANTHROPIC_CONTENT_TRUNCATED, true);
        }
        if (null !== $result) {
            $span->setAttribute(TraceAttributes::ANTHROPIC_TOOL_RESULT_CONTENT, '['.implode(',', array_slice($blocks, 0, $count)).']');
        }
    }

    /**
     * The parts of `$content`, a string or a list of content blocks. A string is one text part.
     *
     * @return list<Part>
     */
    public static function parts(mixed $content): array
    {
        $content = self::wire($content);
        if (is_string($content)) {
            return [['type' => 'text', 'content' => $content]];
        }
        if (!is_array($content)) {
            return [];
        }

        return array_map(self::part(...), array_values($content));
    }

    /**
     * The content blocks of `$content`, the content of a tool result: a string or a list of content blocks, as they
     * are sent to the API. A string is one text block, and no content is an empty list. A text block and a search
     * result block keep all their fields except those whose name starts with `encrypted_`, as {@see self::fields()}
     * says, and so does a block of another of the `$kept` types. Any other block keeps only its type.
     *
     * @param list<string> $kept
     *
     * @return list<array<mixed>>
     */
    public static function blocks(mixed $content, array $kept = ['search_result']): array
    {
        $content = self::wire($content);
        if (is_string($content)) {
            return [['type' => 'text', 'text' => $content]];
        }
        if (!is_array($content)) {
            return [];
        }

        return array_map(static fn (mixed $block): array => self::block($block, $kept), array_values($content));
    }

    /**
     * The content of the result block of a tool that the application does not run: a server tool's, or an MCP
     * tool's. A content that is one object keeps its fields, as {@see self::fields()} says. Any other content is a
     * list of content blocks, as {@see self::blocks()} says, in which a web search result keeps its fields too.
     *
     * @return array<mixed>
     */
    public static function resultContent(mixed $content): array
    {
        $content = self::wire($content);

        return is_array($content) && !array_is_list($content) ? self::fields($content) : self::blocks($content, ['search_result', 'web_search_result']);
    }

    /**
     * `$systemInstructions`, `$inputMessages` and `$outputMessages` without the message parts that make their JSON
     * `$excess` bytes too long, and whether anything was removed or cut. Their parts are one list: those of the
     * system instructions, then those of each input message, then those of each output message. While the JSON is too
     * long and more than one part is left, the first part of that list is removed whole. When the one part left is a
     * text part, its `content` keeps the longest start that fits, as {@see self::textWithin()} says, and the part
     * stays even when none of its `content` does. Any other part that is the one left, such as a tool call or a
     * reasoning part, is removed, because half of its JSON is not JSON. A message that lost all its parts stays
     * without parts, and so does the emptied list of system instructions. What is left can still be too long.
     *
     * @param list<Part>|null $systemInstructions
     * @param list<InputMessage>|null $inputMessages
     * @param list<OutputMessage>|null $outputMessages
     *
     * @return array{list<Part>|null, list<InputMessage>|null, list<OutputMessage>|null, bool}
     */
    private static function fit(?array $systemInstructions, ?array $inputMessages, ?array $outputMessages, int $excess): array
    {
        $lists = null === $systemInstructions ? [] : [$systemInstructions];
        foreach ([...$inputMessages ?? [], ...$outputMessages ?? []] as $message) {
            $lists[] = $message['parts'];
        }
        $left = array_sum(array_map('count', $lists));
        $truncated = false;
        foreach ($lists as $index => $parts) {
            $removed = 0;
            while ($excess > 0 && $removed < count($parts)) {
                $part = $parts[$removed];
                $content = $part['content'] ?? null;
                if (1 === $left && 'text' === $part['type'] && is_string($content)) {
                    $part['content'] = self::textWithin($content, $excess);
                    $parts[$removed] = $part;
                    $truncated = $truncated || $part['content'] !== $content;
                    $excess = 0;

                    break;
                }
                // The JSON of a list is its brackets, its elements, and a comma between each two.
                $excess -= strlen(self::json($part)) + ($removed + 1 < count($parts) ? 1 : 0);
                ++$removed;
                --$left;
                $truncated = true;
            }
            $lists[$index] = array_slice($parts, $removed);
        }

        $next = null === $systemInstructions ? 0 : 1;
        $input = [];
        foreach ($inputMessages ?? [] as $message) {
            $input[] = [...$message, 'parts' => $lists[$next++]];
        }
        $output = [];
        foreach ($outputMessages ?? [] as $message) {
            $output[] = [...$message, 'parts' => $lists[$next++]];
        }

        return [
            null === $systemInstructions ? null : $lists[0],
            null === $inputMessages ? null : $input,
            null === $outputMessages ? null : $output,
            $truncated,
        ];
    }

    /**
     * The longest start of `$text` whose JSON is at least `$excess` bytes shorter than that of `$text`, which is
     * empty when that is all of `$text`. It ends between two characters. The cut is made in the JSON of `$text`,
     * where the bytes are counted and a character can be longer than it is in `$text`, and the start is read back
     * from what is kept.
     */
    private static function textWithin(string $text, int $excess): string
    {
        $json = substr(self::json($text), 1, -1);
        if (strlen($json) <= $excess) {
            return '';
        }
        $kept = mb_strcut($json, 0, strlen($json) - $excess, 'UTF-8');
        $slash = strrpos($kept, '\\');
        if (false !== $slash && $slash > strlen($kept) - 6) {
            $first = $slash;
            while ($first > 0 && '\\' === $kept[$first - 1]) {
                --$first;
            }
            // The last of an odd number of backslashes starts an escape: `\u` and four digits, or one character.
            $escape = 'u' === substr($kept, $slash + 1, 1) ? 6 : 2;
            if (0 === ($slash - $first) % 2 && $slash + $escape > strlen($kept)) {
                $kept = substr($kept, 0, $slash);
            }
        }
        $start = json_decode('"'.$kept.'"', flags: JSON_THROW_ON_ERROR);

        return is_string($start) ? $start : '';
    }

    /**
     * The part of one content block.
     *
     * @return Part
     */
    private static function part(mixed $block): array
    {
        $block = self::wire($block);
        $type = is_array($block) ? ($block['type'] ?? null) : null;
        if (!is_array($block) || !is_string($type)) {
            return ['type' => 'anthropic_unknown'];
        }

        return match (true) {
            'text' === $type => ['type' => 'text', 'content' => $block['text'] ?? null],
            'thinking' === $type => ['type' => 'reasoning', 'content' => $block['thinking'] ?? null],
            // The toolset name of a toolset's member. On any other tool use it is null or absent.
            'tool_use' === $type => ['type' => 'tool_call', 'id' => $block['id'] ?? null, 'name' => $block['name'] ?? null, 'arguments' => $block['input'] ?? null, ...(is_string($block['toolset_name'] ?? null) ? ['anthropic_toolset_name' => $block['toolset_name']] : [])],
            'server_tool_use' === $type => ['type' => 'tool_call', 'id' => $block['id'] ?? null, 'name' => $block['name'] ?? null, 'arguments' => $block['input'] ?? null],
            'mcp_tool_use' === $type => ['type' => 'tool_call', 'id' => $block['id'] ?? null, 'name' => $block['name'] ?? null, 'arguments' => $block['input'] ?? null, 'anthropic_mcp_server_name' => $block['server_name'] ?? null],
            'tool_result' === $type => ['type' => 'tool_call_response', 'id' => $block['tool_use_id'] ?? null, 'response' => self::blocks($block['content'] ?? null)],
            // The result block of a server tool or an MCP tool.
            str_ends_with($type, '_tool_result') => ['type' => 'tool_call_response', 'id' => $block['tool_use_id'] ?? null, 'response' => self::resultContent($block['content'] ?? null)],
            default => ['type' => 'anthropic_'.$type],
        };
    }

    /**
     * One content block of a tool result's content.
     *
     * @param list<string> $kept
     *
     * @return array<mixed>
     */
    private static function block(mixed $block, array $kept): array
    {
        $block = self::wire($block);
        $type = is_array($block) ? ($block['type'] ?? null) : null;
        if (!is_array($block) || !is_string($type)) {
            return ['type' => 'unknown'];
        }

        return 'text' === $type || in_array($type, $kept, true) ? self::fields($block) : ['type' => $type];
    }

    /**
     * The fields of `$object`, an object in a tool result's content, at any depth. A field whose name starts with
     * `encrypted_` is left out. Image and document data is left out because it is large and binary: an image or a
     * document block keeps only its type, and the view of an image or a PDF file loses its content.
     *
     * @param array<mixed> $object
     *
     * @return array<mixed>
     */
    private static function fields(array $object): array
    {
        $type = $object['type'] ?? null;
        if ('image' === $type || 'document' === $type) {
            return ['type' => $type];
        }
        if ('text_editor_code_execution_view_result' === $type && in_array($object['file_type'] ?? null, ['image', 'pdf'], true)) {
            unset($object['content']);
        }
        $fields = [];
        foreach ($object as $name => $value) {
            if (is_string($name) && str_starts_with($name, 'encrypted_')) {
                continue;
            }
            $wire = self::wire($value);
            $fields[$name] = is_array($wire) && [] !== $wire ? self::fields($wire) : $value;
        }

        return $fields;
    }

    /**
     * `$value` as one JSON string. Throws when JSON cannot hold it.
     */
    private static function json(mixed $value): string
    {
        return json_encode($value, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRESERVE_ZERO_FRACTION);
    }

    /**
     * `$value` in the API's shape: a model becomes what it serializes to, and an object its properties.
     */
    private static function wire(mixed $value): mixed
    {
        if ($value instanceof \JsonSerializable) {
            $value = $value->jsonSerialize();
        }

        return is_object($value) ? get_object_vars($value) : $value;
    }
}
