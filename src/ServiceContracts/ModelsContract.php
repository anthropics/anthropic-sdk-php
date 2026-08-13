<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Models\ModelInfo;
use Anthropic\Page;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface ModelsContract
{
    /**
     * @api
     *
     * @param string $modelID model identifier or alias
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $modelID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): ModelInfo;

    /**
     * @api
     *
     * @param string $afterID Query param: ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately after this object.
     * @param string $beforeID Query param: ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately before this object.
     * @param int $limit Query param: Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @return Page<ModelInfo>
     *
     * @throws APIException
     */
    public function list(
        ?string $afterID = null,
        ?string $beforeID = null,
        ?int $limit = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): Page;
}
