<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_all_thinking_turns = array{type: string}
 */
final class BetaAllThinkingTurns implements BaseModel
{
    /** @use SdkModel<beta_all_thinking_turns> */
    use SdkModel;

    #[Api]
    public string $type = 'all';

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(): self
    {
        return new self;
    }
}
