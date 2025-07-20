<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_thinking_delta_alias = array{thinking: string, type: string}
 */
final class BetaThinkingDelta implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'thinking_delta';

    #[Api]
    public string $thinking;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(string $thinking)
    {
        self::introspect();

        $this->thinking = $thinking;
    }
}
