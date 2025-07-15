<?php

declare(strict_types=1);

namespace Anthropic\Resources\Beta;

use Anthropic\Client;
use Anthropic\Contracts\Beta\ModelsContract;
use Anthropic\Core\Serde;
use Anthropic\Core\Util;
use Anthropic\Models\Beta\BetaModelInfo;
use Anthropic\Parameters\Beta\Models\ListParams;
use Anthropic\Parameters\Beta\Models\RetrieveParams;
use Anthropic\RequestOptions;

final class Models implements ModelsContract
{
    public function __construct(private Client $client) {}

    /**
     * @param array{modelID?: string, betas?: list<string>} $params
     */
    public function retrieve(
        string $modelID,
        array $params,
        ?RequestOptions $requestOptions = null
    ): BetaModelInfo {
        [$parsed, $options] = RetrieveParams::parseRequest(
            $params,
            $requestOptions
        );
        $resp = $this->client->request(
            method: 'get',
            path: ['v1/models/%1$s?beta=true', $modelID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: $options,
        );

        // @phpstan-ignore-next-line;
        return Serde::coerce(BetaModelInfo::class, value: $resp);
    }

    /**
     * @param array{
     *   afterID?: string, beforeID?: string, limit?: int, betas?: list<string>
     * } $params
     */
    public function list(
        array $params,
        ?RequestOptions $requestOptions = null
    ): BetaModelInfo {
        [$parsed, $options] = ListParams::parseRequest($params, $requestOptions);
        $query_params = array_flip(['after_id', 'before_id', 'limit']);

        /** @var array<string, string> */
        $header_params = array_diff_key($parsed, $query_params);
        $resp = $this->client->request(
            method: 'get',
            path: 'v1/models?beta=true',
            query: array_intersect_key($parsed, $query_params),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: $options,
        );

        // @phpstan-ignore-next-line;
        return Serde::coerce(BetaModelInfo::class, value: $resp);
    }
}
