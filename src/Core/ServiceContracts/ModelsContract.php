<?php

declare(strict_types=1);

namespace Anthropic\Core\ServiceContracts;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Models\ModelInfo;
use Anthropic\RequestOptions;

use const Anthropic\Core\OMIT as omit;

interface ModelsContract
{
    /**
     * @param list<AnthropicBeta::*|string> $betas optional header to specify the beta version(s) you want to use
     */
    public function retrieve(
        string $modelID,
        $betas = omit,
        ?RequestOptions $requestOptions = null
    ): ModelInfo;

    /**
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
    ): ModelInfo;
}
