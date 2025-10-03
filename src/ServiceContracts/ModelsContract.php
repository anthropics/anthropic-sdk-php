<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Models\ModelInfo;
use Anthropic\Page;
use Anthropic\RequestOptions;

use const Anthropic\Core\OMIT as omit;

interface ModelsContract
{
    /**
     * @api
     *
     * @param list<string|AnthropicBeta> $betas optional header to specify the beta version(s) you want to use
     *
     * @throws APIException
     */
    public function retrieve(
        string $modelID,
        $betas = omit,
        ?RequestOptions $requestOptions = null
    ): ModelInfo;

    /**
     * @api
     *
     * @param array<string, mixed> $params
     *
     * @throws APIException
     */
    public function retrieveRaw(
        string $modelID,
        array $params,
        ?RequestOptions $requestOptions = null
    ): ModelInfo;

    /**
     * @api
     *
     * @param string $afterID ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately after this object.
     * @param string $beforeID ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately before this object.
     * @param int $limit Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     * @param list<string|AnthropicBeta> $betas optional header to specify the beta version(s) you want to use
     *
     * @return Page<ModelInfo>
     *
     * @throws APIException
     */
    public function list(
        $afterID = omit,
        $beforeID = omit,
        $limit = omit,
        $betas = omit,
        ?RequestOptions $requestOptions = null,
    ): Page;

    /**
     * @api
     *
     * @param array<string, mixed> $params
     *
     * @return Page<ModelInfo>
     *
     * @throws APIException
     */
    public function listRaw(
        array $params,
        ?RequestOptions $requestOptions = null
    ): Page;
}
