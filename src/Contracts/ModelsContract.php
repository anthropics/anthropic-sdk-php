<?php

declare(strict_types=1);

namespace Anthropic\Contracts;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Models\ModelInfo;
use Anthropic\Models\ModelListParams;
use Anthropic\Models\ModelRetrieveParams;
use Anthropic\RequestOptions;

interface ModelsContract
{
    /**
     * @param array{
     *   anthropicBeta?: list<AnthropicBeta::*|string>
     * }|ModelRetrieveParams $params
     */
    public function retrieve(
        string $modelID,
        array|ModelRetrieveParams $params,
        ?RequestOptions $requestOptions = null,
    ): ModelInfo;

    /**
     * @param array{
     *   afterID?: string,
     *   beforeID?: string,
     *   limit?: int,
     *   anthropicBeta?: list<AnthropicBeta::*|string>,
     * }|ModelListParams $params
     */
    public function list(
        array|ModelListParams $params,
        ?RequestOptions $requestOptions = null
    ): ModelInfo;
}
