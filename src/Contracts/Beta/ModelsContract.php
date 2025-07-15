<?php

declare(strict_types=1);

namespace Anthropic\Contracts\Beta;

use Anthropic\Models\Beta\BetaModelInfo;
use Anthropic\RequestOptions;

interface ModelsContract
{
    /**
     * @param array{modelID?: string, betas?: list<string>} $params
     */
    public function retrieve(
        string $modelID,
        array $params,
        ?RequestOptions $requestOptions = null
    ): BetaModelInfo;

    /**
     * @param array{
     *   afterID?: string, beforeID?: string, limit?: int, betas?: list<string>
     * } $params
     */
    public function list(
        array $params,
        ?RequestOptions $requestOptions = null
    ): BetaModelInfo;
}
