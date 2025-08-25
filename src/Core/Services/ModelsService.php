<?php

declare(strict_types=1);

namespace Anthropic\Core\Services;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Client;
use Anthropic\Core\Conversion;
use Anthropic\Core\ServiceContracts\ModelsContract;
use Anthropic\Core\Util;
use Anthropic\Models\ModelInfo;
use Anthropic\Models\ModelListParams;
use Anthropic\Models\ModelRetrieveParams;
use Anthropic\RequestOptions;

use const Anthropic\Core\OMIT as omit;

final class ModelsService implements ModelsContract
{
    public function __construct(private Client $client) {}

    /**
     * Get a specific model.
     *
     * The Models API response can be used to determine information about a specific model or resolve a model alias to a model ID.
     *
     * @param list<AnthropicBeta::*|string> $betas optional header to specify the beta version(s) you want to use
     */
    public function retrieve(
        string $modelID,
        $betas = omit,
        ?RequestOptions $requestOptions = null
    ): ModelInfo {
        [$parsed, $options] = ModelRetrieveParams::parseRequest(
            ['betas' => $betas],
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
     * List available models.
     *
     * The Models API response can be used to determine which models are available for use in the API. More recently released models are listed first.
     *
     * @param string $afterID ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately after this object.
     * @param string $beforeID ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately before this object.
     * @param int $limit Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     * @param list<AnthropicBeta::*|string> $betas optional header to specify the beta version(s) you want to use
     */
    public function list(
        $afterID = omit,
        $beforeID = omit,
        $limit = omit,
        $betas = omit,
        ?RequestOptions $requestOptions = null,
    ): ModelInfo {
        [$parsed, $options] = ModelListParams::parseRequest(
            [
                'afterID' => $afterID,
                'beforeID' => $beforeID,
                'limit' => $limit,
                'betas' => $betas,
            ],
            $requestOptions,
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
