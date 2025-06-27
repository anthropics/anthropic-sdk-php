<?php

declare(strict_types=1);

namespace Anthropic\Resources;

use Anthropic\RequestOptions;
use Anthropic\Client;
use Anthropic\Contracts\MessagesContract;
use Anthropic\Core\Serde;
use Anthropic\Models\Metadata;
use Anthropic\Models\MessageParam;
use Anthropic\Models\TextBlockParam;
use Anthropic\Models\ThinkingConfigEnabled;
use Anthropic\Models\ThinkingConfigDisabled;
use Anthropic\Models\ToolChoiceAuto;
use Anthropic\Models\ToolChoiceAny;
use Anthropic\Models\ToolChoiceTool;
use Anthropic\Models\ToolChoiceNone;
use Anthropic\Models\Tool;
use Anthropic\Models\ToolBash20250124;
use Anthropic\Models\ToolTextEditor20250124;
use Anthropic\Models\CacheControlEphemeral;
use Anthropic\Models\WebSearchTool20250305;
use Anthropic\Models\Message;
use Anthropic\Models\MessageTokensCount;
use Anthropic\Parameters\Messages\CreateParams;
use Anthropic\Parameters\Messages\CountTokensParams;
use Anthropic\Resources\Messages\Batches;

class Messages implements MessagesContract
{
    public Batches $batches;

    /**
     * @param array{
     *
     *     maxTokens?: int,
     *     messages?: list<MessageParam>,
     *     model?: string|string,
     *     metadata?: Metadata,
     *     serviceTier?: string,
     *     stopSequences?: list<string>,
     *     stream?: bool,
     *     system?: string|list<TextBlockParam>,
     *     temperature?: float,
     *     thinking?: ThinkingConfigEnabled|ThinkingConfigDisabled,
     *     toolChoice?: ToolChoiceAuto|ToolChoiceAny|ToolChoiceTool|ToolChoiceNone,
     *     tools?: list<Tool|ToolBash20250124|ToolTextEditor20250124|array{
     *
     * name?: string, type?: string, cacheControl?: CacheControlEphemeral
     *
     * }|WebSearchTool20250305>,
     *     topK?: int,
     *     topP?: float,
     *
     * } $params
     * @param RequestOptions|array{
     *
     *     timeout?: float|null,
     *     maxRetries?: int|null,
     *     initialRetryDelay?: float|null,
     *     maxRetryDelay?: float|null,
     *     extraHeaders?: list<string>|null,
     *     extraQueryParams?: list<string>|null,
     *     extraBodyParams?: list<string>|null,
     *
     * }|null $requestOptions
     */
    public function create(array $params, mixed $requestOptions = []): Message
    {
        [$parsed, $options] = CreateParams::parseRequest($params, $requestOptions);
        $resp = $this->client->request(
            method: 'post',
            path: 'v1/messages',
            body: (object) $parsed,
            options: array_merge(['timeout' => 600], $options),
        );

        // @phpstan-ignore-next-line;
        return Serde::coerce(Message::class, value: $resp);
    }

    /**
     * @param array{
     *
     *     messages?: list<MessageParam>,
     *     model?: string|string,
     *     system?: string|list<TextBlockParam>,
     *     thinking?: ThinkingConfigEnabled|ThinkingConfigDisabled,
     *     toolChoice?: ToolChoiceAuto|ToolChoiceAny|ToolChoiceTool|ToolChoiceNone,
     *     tools?: list<Tool|ToolBash20250124|ToolTextEditor20250124|array{
     *
     * name?: string, type?: string, cacheControl?: CacheControlEphemeral
     *
     * }|WebSearchTool20250305>,
     *
     * } $params
     * @param RequestOptions|array{
     *
     *     timeout?: float|null,
     *     maxRetries?: int|null,
     *     initialRetryDelay?: float|null,
     *     maxRetryDelay?: float|null,
     *     extraHeaders?: list<string>|null,
     *     extraQueryParams?: list<string>|null,
     *     extraBodyParams?: list<string>|null,
     *
     * }|null $requestOptions
     */
    public function countTokens(
        array $params,
        mixed $requestOptions = [],
    ): MessageTokensCount {
        [$parsed, $options] = CountTokensParams::parseRequest(
            $params,
            $requestOptions
        );
        $resp = $this->client->request(
            method: 'post',
            path: 'v1/messages/count_tokens',
            body: (object) $parsed,
            options: $options,
        );

        // @phpstan-ignore-next-line;
        return Serde::coerce(MessageTokensCount::class, value: $resp);
    }

    public function __construct(protected Client $client)
    {

        $this->batches = new Batches($client);

    }
}
