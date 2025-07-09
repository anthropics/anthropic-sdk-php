<?php

declare(strict_types=1);

namespace Anthropic\Contracts;

use Anthropic\Models\ModelInfo;
use Anthropic\RequestOptions;

interface ModelsContract
{
    /**
     * @param array{modelID?: string, betas?: list<string|string>} $params
     */
    public function retrieve(
        string $modelID,
        array $params,
        ?RequestOptions $requestOptions = null
    ): ModelInfo;

    /**
     * @param array{
     *   afterID?: string, beforeID?: string, limit?: int, betas?: list<string|string>
     * } $params
     */
    public function list(
        array $params,
        ?RequestOptions $requestOptions = null
    ): ModelInfo;
}
