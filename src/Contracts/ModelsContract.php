<?php

declare(strict_types=1);

namespace Anthropic\Contracts;

use Anthropic\Models\ModelInfo;
use Anthropic\Parameters\Models\ListParams;
use Anthropic\Parameters\Models\RetrieveParams;
use Anthropic\RequestOptions;

interface ModelsContract
{
    /**
     * @param array{anthropicBeta?: list<string>}|RetrieveParams $params
     */
    public function retrieve(
        string $modelID,
        array|RetrieveParams $params,
        ?RequestOptions $requestOptions = null,
    ): ModelInfo;

    /**
     * @param ListParams|array{
     *   afterID?: string, beforeID?: string, limit?: int, anthropicBeta?: list<string>
     * } $params
     */
    public function list(
        array|ListParams $params,
        ?RequestOptions $requestOptions = null
    ): ModelInfo;
}
