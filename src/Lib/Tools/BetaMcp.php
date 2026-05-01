<?php

declare(strict_types=1);

namespace Anthropic\Lib\Tools;

use Anthropic\Beta\Messages\BetaCacheControlEphemeral;
use Anthropic\Beta\Messages\BetaTool;
use Anthropic\Beta\Messages\BetaTool\AllowedCaller;
use Anthropic\Core\FileParam;
use Anthropic\Core\Util;
use Mcp\Client;
use Mcp\Schema\Content\BlobResourceContents;
use Mcp\Schema\Content\Content;
use Mcp\Schema\Content\EmbeddedResource;
use Mcp\Schema\Content\ImageContent;
use Mcp\Schema\Content\PromptMessage;
use Mcp\Schema\Content\ResourceContents;
use Mcp\Schema\Content\TextContent;
use Mcp\Schema\Content\TextResourceContents;
use Mcp\Schema\Result\CallToolResult;
use Mcp\Schema\Result\ReadResourceResult;
use Mcp\Schema\Tool;

/**
 * Helpers for integrating Model Context Protocol (MCP) servers with the Anthropic SDK.
 *
 * These helpers convert types from the official MCP PHP SDK (`mcp/sdk`) into the
 * shapes the Messages API accepts, so you don't have to write glue code yourself.
 *
 * ## Dependency
 *
 * Requires the official `mcp/sdk` package:
 *
 * ```
 * composer require mcp/sdk
 * ```
 *
 * ## Example
 *
 * ```php
 * use Anthropic\Client as Anthropic;
 * use Anthropic\Lib\Tools\BetaMcp;
 * use Mcp\Client;
 * use Mcp\Client\Transport\HttpTransport;
 *
 * $mcp = Client::builder()->build();
 * $mcp->connect(new HttpTransport('https://example.com/mcp'));
 *
 * $anthropic = new Anthropic;
 * $runner = $anthropic->beta->messages->toolRunner(
 *     maxTokens: 1024,
 *     messages: [['role' => 'user', 'content' => 'What is the weather in SF?']],
 *     model: 'claude-opus-4-7',
 *     tools: BetaMcp::tools($mcp->listTools()->tools, $mcp),
 * );
 * $final = $runner->runUntilDone();
 * ```
 *
 * @phpstan-import-type BetaCacheControlEphemeralShape from BetaCacheControlEphemeral
 */
final class BetaMcp
{
    /** @var list<string> */
    private const SUPPORTED_IMAGE_TYPES = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    /**
     * Convert an MCP tool definition into a runnable tool for {@see BetaToolRunner}.
     *
     * @param BetaCacheControlEphemeral|BetaCacheControlEphemeralShape|null $cacheControl cache control configuration
     * @param bool|null $deferLoading if true, tool will not be included in the initial system prompt
     * @param list<AllowedCaller|value-of<AllowedCaller>>|null $allowedCallers restrict which callers may invoke the tool
     * @param bool|null $eagerInputStreaming enable eager input streaming for this tool
     * @param list<array<string, mixed>>|null $inputExamples example inputs for the tool
     * @param bool|null $strict guarantee schema validation on tool names and inputs
     */
    public static function tool(
        Tool $tool,
        Client $client,
        BetaCacheControlEphemeral|array|null $cacheControl = null,
        ?bool $deferLoading = null,
        ?array $allowedCallers = null,
        ?bool $eagerInputStreaming = null,
        ?array $inputExamples = null,
        ?bool $strict = null,
    ): BetaRunnableTool {
        $withArgs = array_filter(
            [
                'inputSchema' => $tool->inputSchema,
                'name' => $tool->name,
                'description' => $tool->description,
                'cacheControl' => $cacheControl,
                'deferLoading' => $deferLoading,
                'allowedCallers' => $allowedCallers,
                'eagerInputStreaming' => $eagerInputStreaming,
                'inputExamples' => $inputExamples,
                'strict' => $strict,
            ],
            static fn (mixed $v): bool => null !== $v,
        );

        // @phpstan-ignore argument.type
        $betaTool = BetaTool::with(...$withArgs);

        $invoker = new BetaMcpToolInvoker($tool->name, $client);

        return new BetaRunnableTool($betaTool, $invoker(...));
    }

    /**
     * Convert a list of MCP tool definitions into runnable tools.
     *
     * @param list<Tool> $tools typically from `$client->listTools()->tools`
     * @param BetaCacheControlEphemeral|BetaCacheControlEphemeralShape|null $cacheControl
     * @param list<AllowedCaller|value-of<AllowedCaller>>|null $allowedCallers
     * @param list<array<string, mixed>>|null $inputExamples
     *
     * @return list<BetaRunnableTool>
     */
    public static function tools(
        array $tools,
        Client $client,
        BetaCacheControlEphemeral|array|null $cacheControl = null,
        ?bool $deferLoading = null,
        ?array $allowedCallers = null,
        ?bool $eagerInputStreaming = null,
        ?array $inputExamples = null,
        ?bool $strict = null,
    ): array {
        return array_map(
            static fn (Tool $tool): BetaRunnableTool => self::tool(
                $tool,
                $client,
                cacheControl: $cacheControl,
                deferLoading: $deferLoading,
                allowedCallers: $allowedCallers,
                eagerInputStreaming: $eagerInputStreaming,
                inputExamples: $inputExamples,
                strict: $strict,
            ),
            $tools,
        );
    }

    /**
     * Convert an MCP prompt message into a Beta message parameter array.
     *
     * @param array<string, mixed>|null $cacheControl forwarded to the produced content block
     *
     * @return array{role: string, content: list<array<string, mixed>>}
     */
    public static function message(
        PromptMessage $message,
        ?array $cacheControl = null,
    ): array {
        return [
            'role' => $message->role->value,
            'content' => [self::content($message->content, $cacheControl)],
        ];
    }

    /**
     * Convert a single MCP content block into a Beta content block array.
     *
     * Handles text, image, and embedded resource content types.
     * Throws {@see UnsupportedMCPValueError} for audio or unknown types.
     *
     * @param array<string, mixed>|null $cacheControl
     *
     * @return array<string, mixed>
     */
    public static function content(
        Content $content,
        ?array $cacheControl = null,
    ): array {
        if ($content instanceof TextContent) {
            $text = $content->text;
            if (!is_string($text)) {
                $text = json_encode($text, flags: Util::JSON_ENCODE_FLAGS);
            }
            $block = ['type' => 'text', 'text' => $text];
            if (null !== $cacheControl) {
                $block['cache_control'] = $cacheControl;
            }

            return $block;
        }

        if ($content instanceof ImageContent) {
            if (!self::isSupportedImageType($content->mimeType)) {
                throw new UnsupportedMCPValueError("Unsupported image MIME type: {$content->mimeType}");
            }
            $block = [
                'type' => 'image',
                'source' => [
                    'type' => 'base64',
                    'data' => $content->data,
                    'media_type' => $content->mimeType,
                ],
            ];
            if (null !== $cacheControl) {
                $block['cache_control'] = $cacheControl;
            }

            return $block;
        }

        if ($content instanceof EmbeddedResource) {
            return self::resourceContentsToBlock($content->resource, $cacheControl);
        }

        // AudioContent or any unknown Content subclass
        throw new UnsupportedMCPValueError("Unsupported MCP content type: {$content->type}");
    }

    /**
     * Convert an MCP resource read result into a Beta content block array.
     *
     * Picks the first item in `contents` whose MIME type is supported by the API.
     *
     * @param array<string, mixed>|null $cacheControl
     *
     * @return array<string, mixed>
     */
    public static function resourceToContent(
        ReadResourceResult $result,
        ?array $cacheControl = null,
    ): array {
        if ([] === $result->contents) {
            throw new UnsupportedMCPValueError('Resource contents array must contain at least one item');
        }

        $supported = null;
        foreach ($result->contents as $item) {
            if (self::isSupportedResourceMimeType($item->mimeType)) {
                $supported = $item;

                break;
            }
        }

        if (null === $supported) {
            $mimeTypes = [];
            foreach ($result->contents as $item) {
                if (null !== $item->mimeType) {
                    $mimeTypes[] = $item->mimeType;
                }
            }
            $available = implode(', ', $mimeTypes);

            throw new UnsupportedMCPValueError(
                "No supported MIME type found in resource contents. Available: {$available}",
            );
        }

        return self::resourceContentsToBlock($supported, $cacheControl);
    }

    /**
     * Convert an MCP resource read result into a {@see FileParam} for `files->upload()`.
     *
     * Uses the first item in `contents` without filtering by MIME type — any resource
     * can become a file upload.
     */
    public static function resourceToFile(ReadResourceResult $result): FileParam
    {
        if ([] === $result->contents) {
            throw new UnsupportedMCPValueError('Resource contents array must contain at least one item');
        }

        $resource = $result->contents[array_key_first($result->contents)];

        $filename = 'file';
        $path = parse_url($resource->uri, PHP_URL_PATH);
        if (is_string($path) && '' !== $path) {
            $basename = basename($path);
            if ('' !== $basename) {
                $filename = $basename;
            }
        }

        if ($resource instanceof BlobResourceContents) {
            $bytes = base64_decode($resource->blob, true);
            if (false === $bytes) {
                throw new UnsupportedMCPValueError("Resource blob is not valid base64. URI: {$resource->uri}");
            }
        } elseif ($resource instanceof TextResourceContents) {
            $bytes = $resource->text;
        } else {
            throw new UnsupportedMCPValueError("Unsupported resource contents type. URI: {$resource->uri}");
        }

        return FileParam::fromString(
            $bytes,
            $filename,
            null !== $resource->mimeType && '' !== $resource->mimeType
                ? $resource->mimeType
                : FileParam::DEFAULT_CONTENT_TYPE,
        );
    }

    // -------------------------------------------------------------------------
    // Internals
    // -------------------------------------------------------------------------

    /**
     * @internal Called by {@see BetaMcpToolInvoker}. Not part of the public API.
     *
     * @return string|list<array<string, mixed>>
     */
    public static function convertToolResult(CallToolResult $result): string|array
    {
        if ($result->isError) {
            $blocks = array_map(
                static fn (Content $item): array => self::content($item),
                array_values($result->content),
            );

            throw new \RuntimeException(self::renderErrorBlocks($blocks));
        }

        if ([] === $result->content && null !== $result->structuredContent) {
            return json_encode($result->structuredContent, JSON_THROW_ON_ERROR);
        }

        return array_map(
            static fn (Content $item): array => self::content($item),
            array_values($result->content),
        );
    }

    /**
     * @param array<string, mixed>|null $cacheControl
     *
     * @return array<string, mixed>
     */
    private static function resourceContentsToBlock(
        ResourceContents $resource,
        ?array $cacheControl,
    ): array {
        $mimeType = $resource->mimeType;

        if (is_string($mimeType) && self::isSupportedImageType($mimeType)) {
            if (!$resource instanceof BlobResourceContents) {
                throw new UnsupportedMCPValueError(
                    "Image resource must have blob data, not text. URI: {$resource->uri}",
                );
            }
            $block = [
                'type' => 'image',
                'source' => [
                    'type' => 'base64',
                    'data' => $resource->blob,
                    'media_type' => $mimeType,
                ],
            ];
            if (null !== $cacheControl) {
                $block['cache_control'] = $cacheControl;
            }

            return $block;
        }

        if ('application/pdf' === $mimeType) {
            if (!$resource instanceof BlobResourceContents) {
                throw new UnsupportedMCPValueError(
                    "PDF resource must have blob data, not text. URI: {$resource->uri}",
                );
            }
            $block = [
                'type' => 'document',
                'source' => [
                    'type' => 'base64',
                    'data' => $resource->blob,
                    'media_type' => 'application/pdf',
                ],
            ];
            if (null !== $cacheControl) {
                $block['cache_control'] = $cacheControl;
            }

            return $block;
        }

        if (null === $mimeType || str_starts_with($mimeType, 'text/')) {
            if ($resource instanceof TextResourceContents) {
                $data = $resource->text;
            } elseif ($resource instanceof BlobResourceContents) {
                $decoded = base64_decode($resource->blob, true);
                if (false === $decoded) {
                    throw new UnsupportedMCPValueError(
                        "Resource blob is not valid base64. URI: {$resource->uri}",
                    );
                }
                $data = $decoded;
            } else {
                throw new UnsupportedMCPValueError(
                    "Unsupported resource contents type. URI: {$resource->uri}",
                );
            }
            $block = [
                'type' => 'document',
                'source' => ['type' => 'text', 'data' => $data, 'media_type' => 'text/plain'],
            ];
            if (null !== $cacheControl) {
                $block['cache_control'] = $cacheControl;
            }

            return $block;
        }

        throw new UnsupportedMCPValueError(
            "Unsupported MIME type \"{$mimeType}\" for resource: {$resource->uri}",
        );
    }

    /**
     * @param list<array<string, mixed>> $blocks
     */
    private static function renderErrorBlocks(array $blocks): string
    {
        $parts = [];
        foreach ($blocks as $block) {
            if (('text' === ($block['type'] ?? null)) && is_string($block['text'] ?? null)) {
                $parts[] = $block['text'];
            } else {
                $parts[] = json_encode($block, JSON_UNESCAPED_SLASHES) ?: '';
            }
        }
        $joined = implode("\n", array_filter($parts, static fn (string $p): bool => '' !== $p));

        return '' !== $joined ? $joined : 'MCP tool reported an error';
    }

    private static function isSupportedImageType(string $mimeType): bool
    {
        return in_array($mimeType, self::SUPPORTED_IMAGE_TYPES, true);
    }

    private static function isSupportedResourceMimeType(?string $mimeType): bool
    {
        if (null === $mimeType) {
            return true;
        }

        return str_starts_with($mimeType, 'text/')
            || 'application/pdf' === $mimeType
            || self::isSupportedImageType($mimeType);
    }

}
