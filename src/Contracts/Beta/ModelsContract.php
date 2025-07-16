<?php

declare(strict_types=1);

namespace Anthropic\Contracts\Beta;

use Anthropic\Models\AnthropicBeta\UnionMember1;
use Anthropic\Models\Beta\BetaModelInfo;
use Anthropic\Parameters\Beta\ModelListParam;
use Anthropic\Parameters\Beta\ModelRetrieveParam;
use Anthropic\RequestOptions;

interface ModelsContract
{
    /**
     * @param ModelRetrieveParam|array{
     *   anthropicBeta?: list<string|UnionMember1::*>
     * } $params
     */
    public function retrieve(
        string $modelID,
        array|ModelRetrieveParam $params,
        ?RequestOptions $requestOptions = null,
    ): BetaModelInfo;

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
    ): BetaModelInfo;
}
