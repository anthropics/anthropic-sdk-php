<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaToolUsesKeepShape = array{type?: 'tool_uses', value: int}
 */
final class BetaToolUsesKeep implements BaseModel
{
    /** @use SdkModel<BetaToolUsesKeepShape> */
    use SdkModel;

    /** @var 'tool_uses' $type */
    #[Required]
    public string $type = 'tool_uses';

    #[Required]
    public int $value;

    /**
     * `new BetaToolUsesKeep()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaToolUsesKeep::with(value: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaToolUsesKeep)->withValue(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(int $value): self
    {
        $self = new self;

        $self['value'] = $value;

        return $self;
    }

    public function withValue(int $value): self
    {
        $self = clone $this;
        $self['value'] = $value;

        return $self;
    }
}
