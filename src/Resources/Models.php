<?php

declare(strict_types=1);

namespace Anthropic\Resources;

use Anthropic\Client;
use Anthropic\Contracts\ModelsContract;
use Anthropic\Core\Serde;
use Anthropic\Core\Util;
use Anthropic\Models\ModelInfo;
use Anthropic\Parameters\Models\ListParams;
use Anthropic\Parameters\Models\RetrieveParams;
use Anthropic\RequestOptions;

class Models implements ModelsContract
{
    public function __construct(protected Client $client) {}

    /**
     * @param array{modelID?: string, betas?: list<string|string>} $params
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
        string $modelID,
        array $params,
        mixed $requestOptions = []
    ): ModelInfo {
        [$parsed, $options] = RetrieveParams::parseRequest(
            $params,
            $requestOptions
        );
        $resp = $this->client->request(
            method: 'get',
            path: ['v1/models/%1$s', $modelID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: $options,
        );

        // @phpstan-ignore-next-line;
        return Serde::coerce(ModelInfo::class, value: $resp);
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
    public function list(array $params, mixed $requestOptions = []): ModelInfo
    {
        [$parsed, $options] = ListParams::parseRequest($params, $requestOptions);
        $query_params = array_flip(['after_id', 'before_id', 'limit']);

        /** @var array<string, string> */
        $header_params = array_diff_key($parsed, $query_params);
        $resp = $this->client->request(
            method: 'get',
            path: 'v1/models',
            query: array_intersect_key($parsed, $query_params),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: $options,
        );

        // @phpstan-ignore-next-line;
        return Serde::coerce(ModelInfo::class, value: $resp);
    }
}
