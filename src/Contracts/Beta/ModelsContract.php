<?php

declare(strict_types=1);

namespace Anthropic\Contracts\Beta;

use Anthropic\Models\AnthropicBeta\UnionMember1;
use Anthropic\Models\Beta\BetaModelInfo;
use Anthropic\Parameters\Beta\Models\ListParams;
use Anthropic\Parameters\Beta\Models\RetrieveParams;
use Anthropic\RequestOptions;

interface ModelsContract
{
    /**
     * @param RetrieveParams|array{
     *   anthropicBeta?: list<string|UnionMember1::*>
     * } $params
     */
    public function retrieve(
        string $modelID,
        array|RetrieveParams $params,
        ?RequestOptions $requestOptions = null,
    ): BetaModelInfo;

    /**
     * @param ListParams|array{
     *   afterID?: string,
     *   beforeID?: string,
     *   limit?: int,
     *   anthropicBeta?: list<string|UnionMember1::*>,
     * } $params
     */
    public function list(
        array|ListParams $params,
        ?RequestOptions $requestOptions = null
    ): BetaModelInfo;
}
