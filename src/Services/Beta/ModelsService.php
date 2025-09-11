<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Models\BetaModelInfo;
use Anthropic\Beta\Models\ModelListParams;
use Anthropic\Beta\Models\ModelRetrieveParams;
use Anthropic\Client;
use Anthropic\Core\Util;
use Anthropic\Page;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\ModelsContract;

use const Anthropic\Core\OMIT as omit;

final class ModelsService implements ModelsContract
{
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Get a specific model.
     *
     * The Models API response can be used to determine information about a specific model or resolve a model alias to a model ID.
     *
     * @param list<string|AnthropicBeta> $betas optional header to specify the beta version(s) you want to use
     */
    public function retrieve(
        string $modelID,
        $betas = omit,
        ?RequestOptions $requestOptions = null
    ): BetaModelInfo {
        [$parsed, $options] = ModelRetrieveParams::parseRequest(
            ['betas' => $betas],
            $requestOptions
        );

        // @phpstan-ignore-next-line;
        return $this->client->request(
            method: 'get',
            path: ['v1/models/%1$s?beta=true', $modelID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: $options,
            convert: BetaModelInfo::class,
        );
    }

    /**
     * @api
     *
     * List available models.
     *
     * The Models API response can be used to determine which models are available for use in the API. More recently released models are listed first.
     *
     * @param string $afterID ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately after this object.
     * @param string $beforeID ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately before this object.
     * @param int $limit Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     * @param list<string|AnthropicBeta> $betas optional header to specify the beta version(s) you want to use
     *
     * @return Page<BetaModelInfo>
     */
    public function list(
        $afterID = omit,
        $beforeID = omit,
        $limit = omit,
        $betas = omit,
        ?RequestOptions $requestOptions = null,
    ): Page {
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

        // @phpstan-ignore-next-line;
        return $this->client->request(
            method: 'get',
            path: 'v1/models?beta=true',
            query: array_intersect_key($parsed, $query_params),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: $options,
            convert: BetaModelInfo::class,
            page: Page::class,
        );
    }
}
