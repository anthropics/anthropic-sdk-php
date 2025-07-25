<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type thinking_delta_alias = array{thinking: string, type: string}
 */
final class ThinkingDelta implements BaseModel
{
    use ModelTrait;

    #[Api]
    public string $type = 'thinking_delta';

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
    public static function new(string $thinking): self
    {
        $obj = new self;

        $obj->thinking = $thinking;

        return $obj;
    }

    public function setThinking(string $thinking): self
    {
        $this->thinking = $thinking;

        return $this;
    }
}
