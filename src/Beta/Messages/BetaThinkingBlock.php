<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_thinking_block_alias = array{
 *   signature: string, thinking: string, type: string
 * }
 */
final class BetaThinkingBlock implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'thinking';

    #[Api]
    public string $signature;

    #[Api]
    public string $thinking;

    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function new(string $signature, string $thinking): self
    {
        $obj = new self;

        $obj->signature = $signature;
        $obj->thinking = $thinking;

        return $obj;
    }

    public function setSignature(string $signature): self
    {
        $this->signature = $signature;

        return $this;
    }

    public function setThinking(string $thinking): self
    {
        $this->thinking = $thinking;

        return $this;
    }
}
