<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaThinkingConfigAdaptiveShape = array{type: 'adaptive'}
 */
final class BetaThinkingConfigAdaptive implements BaseModel
{
    /** @use SdkModel<BetaThinkingConfigAdaptiveShape> */
    use SdkModel;

    /** @var 'adaptive' $type */
    #[Required]
    public string $type = 'adaptive';

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

    /**
     * @param 'adaptive' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
