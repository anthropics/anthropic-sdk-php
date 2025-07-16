<?php

declare(strict_types=1);

namespace Anthropic\Resources\Beta\Messages;

use Anthropic\Client;
use Anthropic\Contracts\Beta\Messages\BatchesContract;
use Anthropic\Core\Serde;
use Anthropic\Core\Util;
use Anthropic\Models\AnthropicBeta\UnionMember1;
use Anthropic\Models\Beta\Messages\BetaDeletedMessageBatch;
use Anthropic\Models\Beta\Messages\BetaMessageBatch;
use Anthropic\Models\Beta\Messages\BetaMessageBatchIndividualResponse;
use Anthropic\Parameters\Beta\Messages\Batches\CancelParams;
use Anthropic\Parameters\Beta\Messages\Batches\CreateParams;
use Anthropic\Parameters\Beta\Messages\Batches\CreateParams\Request;
use Anthropic\Parameters\Beta\Messages\Batches\DeleteParams;
use Anthropic\Parameters\Beta\Messages\Batches\ListParams;
use Anthropic\Parameters\Beta\Messages\Batches\ResultsParams;
use Anthropic\Parameters\Beta\Messages\Batches\RetrieveParams;
use Anthropic\RequestOptions;

final class Batches implements BatchesContract
{
    public function __construct(private Client $client) {}

    /**
     * @param CreateParams|array{
     *   requests?: list<Request>, anthropicBeta?: list<string|UnionMember1::*>
     * } $params
     */
    public function create(
        array|CreateParams $params,
        ?RequestOptions $requestOptions = null
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
     * @param RetrieveParams|array{
     *   anthropicBeta?: list<string|UnionMember1::*>
     * } $params
     */
    public function retrieve(
        string $messageBatchID,
        array|RetrieveParams $params,
        ?RequestOptions $requestOptions = null,
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
     * @param ListParams|array{
     *   afterID?: string,
     *   beforeID?: string,
     *   limit?: int,
     *   anthropicBeta?: list<string|UnionMember1::*>,
     * } $params
     */
    public function list(
        array|ListParams $params,
        ?RequestOptions $requestOptions = null
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
     * @param array{anthropicBeta?: list<string|UnionMember1::*>}|DeleteParams $params
     */
    public function delete(
        string $messageBatchID,
        array|DeleteParams $params,
        ?RequestOptions $requestOptions = null,
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
     * @param array{anthropicBeta?: list<string|UnionMember1::*>}|CancelParams $params
     */
    public function cancel(
        string $messageBatchID,
        array|CancelParams $params,
        ?RequestOptions $requestOptions = null,
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
     * @param array{anthropicBeta?: list<string|UnionMember1::*>}|ResultsParams $params
     */
    public function results(
        string $messageBatchID,
        array|ResultsParams $params,
        ?RequestOptions $requestOptions = null,
    ): BetaMessageBatchIndividualResponse {
        [$parsed, $options] = ResultsParams::parseRequest($params, $requestOptions);
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
