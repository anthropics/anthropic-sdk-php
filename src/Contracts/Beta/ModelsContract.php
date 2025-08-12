<?php

declare(strict_types=1);

namespace Anthropic\Contracts\Beta;

use Anthropic\Beta\AnthropicBeta\UnionMember1;
use Anthropic\Beta\Models\BetaModelInfo;
use Anthropic\Beta\Models\ModelListParams;
use Anthropic\Beta\Models\ModelRetrieveParams;
use Anthropic\RequestOptions;

interface ModelsContract
{
    /**
     * @param array{
     *   anthropicBeta?: list<string|UnionMember1::*>
     * }|ModelRetrieveParams $params
     */
    public function retrieve(
        string $modelID,
        array|ModelRetrieveParams $params,
        ?RequestOptions $requestOptions = null,
    ): BetaModelInfo;

    /**
     * @param array{
     *   afterID?: string,
     *   beforeID?: string,
     *   limit?: int,
     *   anthropicBeta?: list<string|UnionMember1::*>,
     * }|ModelListParams $params
     */
    public function list(
        array|ModelListParams $params,
        ?RequestOptions $requestOptions = null
    ): BetaModelInfo;
}
