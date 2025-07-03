<?php

declare(strict_types=1);

namespace Anthropic\Resources\Beta\Messages;

use Anthropic\Client;
use Anthropic\Contracts\Beta\Messages\BatchesContract;
use Anthropic\Core\Serde;
use Anthropic\Core\Util;
use Anthropic\Models\Beta\BetaCodeExecutionTool20250522;
use Anthropic\Models\Beta\BetaMessageParam;
use Anthropic\Models\Beta\BetaMetadata;
use Anthropic\Models\Beta\BetaRequestMCPServerURLDefinition;
use Anthropic\Models\Beta\BetaTextBlockParam;
use Anthropic\Models\Beta\BetaThinkingConfigDisabled;
use Anthropic\Models\Beta\BetaThinkingConfigEnabled;
use Anthropic\Models\Beta\BetaTool;
use Anthropic\Models\Beta\BetaToolBash20241022;
use Anthropic\Models\Beta\BetaToolBash20250124;
use Anthropic\Models\Beta\BetaToolChoiceAny;
use Anthropic\Models\Beta\BetaToolChoiceAuto;
use Anthropic\Models\Beta\BetaToolChoiceNone;
use Anthropic\Models\Beta\BetaToolChoiceTool;
use Anthropic\Models\Beta\BetaToolComputerUse20241022;
use Anthropic\Models\Beta\BetaToolComputerUse20250124;
use Anthropic\Models\Beta\BetaToolTextEditor20241022;
use Anthropic\Models\Beta\BetaToolTextEditor20250124;
use Anthropic\Models\Beta\BetaToolTextEditor20250429;
use Anthropic\Models\Beta\BetaWebSearchTool20250305;
use Anthropic\Models\Beta\Messages\BetaDeletedMessageBatch;
use Anthropic\Models\Beta\Messages\BetaMessageBatch;
use Anthropic\Models\Beta\Messages\BetaMessageBatchIndividualResponse;
use Anthropic\Parameters\Beta\Messages\Batches\CancelParams;
use Anthropic\Parameters\Beta\Messages\Batches\CreateParams;
use Anthropic\Parameters\Beta\Messages\Batches\DeleteParams;
use Anthropic\Parameters\Beta\Messages\Batches\ListParams;
use Anthropic\Parameters\Beta\Messages\Batches\ResultsParams;
use Anthropic\Parameters\Beta\Messages\Batches\RetrieveParams;
use Anthropic\RequestOptions;

class Batches implements BatchesContract
{
    public function __construct(protected Client $client) {}

    /**
     * @param array{
     *
     *     requests?: list<array{
     *
     *         customID?: string,
     *         params?: array{
     *
     *             maxTokens?: int,
     *             messages?: list<BetaMessageParam>,
     *             model?: string|string,
     *             container?: string|null,
     *             mcpServers?: list<BetaRequestMCPServerURLDefinition>,
     *             metadata?: BetaMetadata,
     *             serviceTier?: string,
     *             stopSequences?: list<string>,
     *             stream?: bool,
     *             system?: string|list<BetaTextBlockParam>,
     *             temperature?: float,
     *             thinking?: BetaThinkingConfigEnabled|BetaThinkingConfigDisabled,
     *             toolChoice?: BetaToolChoiceAuto|BetaToolChoiceAny|BetaToolChoiceTool|BetaToolChoiceNone,
     *             tools?: list<BetaTool|BetaToolBash20241022|BetaToolBash20250124|BetaCodeExecutionTool20250522|BetaToolComputerUse20241022|BetaToolComputerUse20250124|BetaToolTextEditor20241022|BetaToolTextEditor20250124|BetaToolTextEditor20250429|BetaWebSearchTool20250305>,
     *             topK?: int,
     *             topP?: float,
     *
     * },
     *
     * }>,
     *     betas?: list<string|string>,
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
        mixed $requestOptions = []
    ): BetaMessageBatch {
        [$parsed, $options] = CreateParams::parseRequest($params, $requestOptions);
        $header_params = ['betas' => 'anthropic-beta'];
        $resp = $this->client->request(
            method: 'post',
            path: 'v1/messages/batches?beta=true',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_keys($header_params)),
                $header_params
            ),
            body: (object) array_diff_key($parsed, array_keys($header_params)),
            options: array_merge(
                ['extraHeaders' => ['anthropic-beta' => 'message-batches-2024-09-24']],
                $options,
            ),
        );

        // @phpstan-ignore-next-line;
        return Serde::coerce(BetaMessageBatch::class, value: $resp);
    }

    /**
     * @param array{messageBatchID?: string, betas?: list<string|string>} $params
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
        mixed $requestOptions = []
    ): BetaMessageBatch {
        [$parsed, $options] = RetrieveParams::parseRequest(
            $params,
            $requestOptions
        );
        $resp = $this->client->request(
            method: 'get',
            path: ['v1/messages/batches/%1$s?beta=true', $messageBatchID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: array_merge(
                ['extraHeaders' => ['anthropic-beta' => 'message-batches-2024-09-24']],
                $options,
            ),
        );

        // @phpstan-ignore-next-line;
        return Serde::coerce(BetaMessageBatch::class, value: $resp);
    }

    /**
     * @param array{
     *
     *     afterID?: string,
     *     beforeID?: string,
     *     limit?: int,
     *     betas?: list<string|string>,
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
    public function list(
        array $params,
        mixed $requestOptions = []
    ): BetaMessageBatch {
        [$parsed, $options] = ListParams::parseRequest($params, $requestOptions);
        $query_params = array_flip(['after_id', 'before_id', 'limit']);

        /** @var array<string, string> */
        $header_params = array_diff_key($parsed, $query_params);
        $resp = $this->client->request(
            method: 'get',
            path: 'v1/messages/batches?beta=true',
            query: array_intersect_key($parsed, $query_params),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: array_merge(
                ['extraHeaders' => ['anthropic-beta' => 'message-batches-2024-09-24']],
                $options,
            ),
        );

        // @phpstan-ignore-next-line;
        return Serde::coerce(BetaMessageBatch::class, value: $resp);
    }

    /**
     * @param array{messageBatchID?: string, betas?: list<string|string>} $params
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
        mixed $requestOptions = []
    ): BetaDeletedMessageBatch {
        [$parsed, $options] = DeleteParams::parseRequest($params, $requestOptions);
        $resp = $this->client->request(
            method: 'delete',
            path: ['v1/messages/batches/%1$s?beta=true', $messageBatchID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: array_merge(
                ['extraHeaders' => ['anthropic-beta' => 'message-batches-2024-09-24']],
                $options,
            ),
        );

        // @phpstan-ignore-next-line;
        return Serde::coerce(BetaDeletedMessageBatch::class, value: $resp);
    }

    /**
     * @param array{messageBatchID?: string, betas?: list<string|string>} $params
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
        mixed $requestOptions = []
    ): BetaMessageBatch {
        [$parsed, $options] = CancelParams::parseRequest($params, $requestOptions);
        $resp = $this->client->request(
            method: 'post',
            path: ['v1/messages/batches/%1$s/cancel?beta=true', $messageBatchID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: array_merge(
                ['extraHeaders' => ['anthropic-beta' => 'message-batches-2024-09-24']],
                $options,
            ),
        );

        // @phpstan-ignore-next-line;
        return Serde::coerce(BetaMessageBatch::class, value: $resp);
    }

    /**
     * @param array{messageBatchID?: string, betas?: list<string|string>} $params
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
        mixed $requestOptions = []
    ): BetaMessageBatchIndividualResponse {
        [$parsed, $options] = ResultsParams::parseRequest(
            $params,
            $requestOptions
        );
        $resp = $this->client->request(
            method: 'get',
            path: ['v1/messages/batches/%1$s/results?beta=true', $messageBatchID],
            headers: Util::array_transform_keys(
                ['Accept' => 'application/x-jsonl', ...$parsed],
                ['betas' => 'anthropic-beta'],
            ),
            options: array_merge(
                ['extraHeaders' => ['anthropic-beta' => 'message-batches-2024-09-24']],
                $options,
            ),
        );

        // @phpstan-ignore-next-line;
        return Serde::coerce(
            BetaMessageBatchIndividualResponse::class,
            value: $resp
        );
    }
}
