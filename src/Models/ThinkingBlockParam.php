<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type thinking_block_param_alias = array{
 *   signature: string, thinking: string, type: string
 * }
 */
final class ThinkingBlockParam implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'thinking';

    #[Api]
    public string $signature;

    #[Api]
    public string $thinking;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(string $signature, string $thinking)
    {
        self::introspect();

        $this->signature = $signature;
        $this->thinking = $thinking;
    }
}
