<?php

declare(strict_types=1);

namespace Anthropic\Resources;

use Anthropic\Client;
use Anthropic\Contracts\ModelsContract;
use Anthropic\Core\Conversion;
use Anthropic\Core\Util;
use Anthropic\Models\AnthropicBeta\UnionMember1;
use Anthropic\Models\ModelInfo;
use Anthropic\Parameters\ModelListParam;
use Anthropic\Parameters\ModelRetrieveParam;
use Anthropic\RequestOptions;

final class Models implements ModelsContract
{
    public function __construct(private Client $client) {}

    /**
     * @param ModelRetrieveParam|array{
     *   anthropicBeta?: list<string|UnionMember1::*>
     * } $params
     */
    public function retrieve(
        string $modelID,
        array|ModelRetrieveParam $params,
        ?RequestOptions $requestOptions = null,
    ): ModelInfo {
        [$parsed, $options] = ModelRetrieveParam::parseRequest(
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
        return Conversion::coerce(ModelInfo::class, value: $resp);
    }

    /**
     * @param ModelListParam|array{
     *   afterID?: string,
     *   beforeID?: string,
     *   limit?: int,
     *   anthropicBeta?: list<string|UnionMember1::*>,
     * } $params
     */
    public function list(
        array|ModelListParam $params,
        ?RequestOptions $requestOptions = null
    ): ModelInfo {
        [$parsed, $options] = ModelListParam::parseRequest(
            $params,
            $requestOptions
        );
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
        return Conversion::coerce(ModelInfo::class, value: $resp);
    }
}
