<?php

declare(strict_types=1);

namespace Anthropic\Resources\Messages;

use Anthropic\RequestOptions;
use Anthropic\Client;
use Anthropic\Contracts\Messages\BatchesContract;
use Anthropic\Core\Serde;
use Anthropic\Models\MessageParam;
use Anthropic\Models\Metadata;
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
use Anthropic\Models\Messages\MessageBatch;
use Anthropic\Models\Messages\DeletedMessageBatch;
use Anthropic\Models\Messages\MessageBatchIndividualResponse;
use Anthropic\Parameters\Messages\Batches\CreateParams;
use Anthropic\Parameters\Messages\Batches\ListParams;

class Batches implements BatchesContract
{
    /**
     * @param array{
     *
     *     requests?: list<array{
     *
     *         customID?: string,
     *         params?: array{
     *
     *             maxTokens?: int,
     *             messages?: list<MessageParam>,
     *             model?: string|string,
     *             metadata?: Metadata,
     *             serviceTier?: string,
     *             stopSequences?: list<string>,
     *             stream?: bool,
     *             system?: string|list<TextBlockParam>,
     *             temperature?: float,
     *             thinking?: ThinkingConfigEnabled|ThinkingConfigDisabled,
     *             toolChoice?: ToolChoiceAuto|ToolChoiceAny|ToolChoiceTool|ToolChoiceNone,
     *             tools?: list<Tool|ToolBash20250124|ToolTextEditor20250124|array{
     *
     *                 name?: string,
     *                 type?: string,
     *                 cacheControl?: CacheControlEphemeral,
     *
     * }|WebSearchTool20250305>,
     *             topK?: int,
     *             topP?: float,
     *
     * },
     *
     * }>,
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
    public function create(
        array $params,
        mixed $requestOptions = [],
    ): MessageBatch {
        [$parsed, $options] = CreateParams::parseRequest($params, $requestOptions);
        $resp = $this->client->request(
            method: 'post',
            path: 'v1/messages/batches',
            body: (object) $parsed,
            options: $options,
        );

        // @phpstan-ignore-next-line;
        return Serde::coerce(MessageBatch::class, value: $resp);
    }

    /**
     * @param array{messageBatchID?: string} $params
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
    public function retrieve(
        string $messageBatchID,
        array $params,
        mixed $requestOptions = [],
    ): MessageBatch {
        $resp = $this->client->request(
            method: 'get',
            path: ['v1/messages/batches/%1$s', $messageBatchID],
            options: $requestOptions,
        );

        // @phpstan-ignore-next-line;
        return Serde::coerce(MessageBatch::class, value: $resp);
    }

    /**
     * @param array{afterID?: string, beforeID?: string, limit?: int} $params
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
    public function list(
        array $params,
        mixed $requestOptions = [],
    ): MessageBatch {
        [$parsed, $options] = ListParams::parseRequest($params, $requestOptions);
        $resp = $this->client->request(
            method: 'get',
            path: 'v1/messages/batches',
            query: $parsed,
            options: $options,
        );

        // @phpstan-ignore-next-line;
        return Serde::coerce(MessageBatch::class, value: $resp);
    }

    /**
     * @param array{messageBatchID?: string} $params
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
    public function delete(
        string $messageBatchID,
        array $params,
        mixed $requestOptions = [],
    ): DeletedMessageBatch {
        $resp = $this->client->request(
            method: 'delete',
            path: ['v1/messages/batches/%1$s', $messageBatchID],
            options: $requestOptions,
        );

        // @phpstan-ignore-next-line;
        return Serde::coerce(DeletedMessageBatch::class, value: $resp);
    }

    /**
     * @param array{messageBatchID?: string} $params
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
    public function cancel(
        string $messageBatchID,
        array $params,
        mixed $requestOptions = [],
    ): MessageBatch {
        $resp = $this->client->request(
            method: 'post',
            path: ['v1/messages/batches/%1$s/cancel', $messageBatchID],
            options: $requestOptions,
        );

        // @phpstan-ignore-next-line;
        return Serde::coerce(MessageBatch::class, value: $resp);
    }

    /**
     * @param array{messageBatchID?: string} $params
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
    public function results(
        string $messageBatchID,
        array $params,
        mixed $requestOptions = [],
    ): MessageBatchIndividualResponse {
        $resp = $this->client->request(
            method: 'get',
            path: ['v1/messages/batches/%1$s/results', $messageBatchID],
            headers: ['Accept' => 'application/x-jsonl'],
            options: $requestOptions,
        );

        // @phpstan-ignore-next-line;
        return Serde::coerce(MessageBatchIndividualResponse::class, value: $resp);
    }

    public function __construct(protected Client $client)
    {
    }
}
