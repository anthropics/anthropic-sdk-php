<?php

declare(strict_types=1);

namespace Anthropic\Resources\Beta;

use Anthropic\Client;
use Anthropic\Contracts\Beta\ModelsContract;
use Anthropic\Core\Conversion;
use Anthropic\Core\Util;
use Anthropic\Models\AnthropicBeta\UnionMember1;
use Anthropic\Models\Beta\BetaModelInfo;
use Anthropic\Parameters\Beta\ModelListParam;
use Anthropic\Parameters\Beta\ModelRetrieveParam;
use Anthropic\RequestOptions;

final class Models implements ModelsContract
{
    public function __construct(private Client $client) {}

    /**
     * Get a specific model.
     *
     * The Models API response can be used to determine information about a specific model or resolve a model alias to a model ID.
     *
     * @param array{
     *   anthropicBeta?: list<string|UnionMember1::*>
     * }|ModelRetrieveParam $params
     */
    public function retrieve(
        string $modelID,
        array|ModelRetrieveParam $params,
        ?RequestOptions $requestOptions = null,
    ): BetaModelInfo {
        [$parsed, $options] = ModelRetrieveParam::parseRequest(
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
        return Conversion::coerce(BetaModelInfo::class, value: $resp);
    }

    /**
     * List available models.
     *
     * The Models API response can be used to determine which models are available for use in the API. More recently released models are listed first.
     *
     * @param array{
     *   afterID?: string,
     *   beforeID?: string,
     *   limit?: int,
     *   anthropicBeta?: list<string|UnionMember1::*>,
     * }|ModelListParam $params
     */
    public function list(
        array|ModelListParam $params,
        ?RequestOptions $requestOptions = null
    ): BetaModelInfo {
        [$parsed, $options] = ModelListParam::parseRequest(
            $params,
            $requestOptions
        );
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
        return Conversion::coerce(BetaModelInfo::class, value: $resp);
    }
}
