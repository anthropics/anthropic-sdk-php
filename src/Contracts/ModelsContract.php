<?php

declare(strict_types=1);

namespace Anthropic\Contracts;

use Anthropic\Models\AnthropicBeta\UnionMember1;
use Anthropic\Models\ModelInfo;
use Anthropic\Parameters\ModelListParam;
use Anthropic\Parameters\ModelRetrieveParam;
use Anthropic\RequestOptions;

interface ModelsContract
{
    /**
     * @param array{
     *   anthropicBeta?: list<string|UnionMember1::*>
     * }|ModelRetrieveParam $params
     */
    public function retrieve(
        string $modelID,
        array|ModelRetrieveParam $params,
        ?RequestOptions $requestOptions = null,
    ): ModelInfo;

    /**
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
    ): ModelInfo;
}
