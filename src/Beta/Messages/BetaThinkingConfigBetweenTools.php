<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type BetaThinkingConfigBetweenToolsShape = array{type: 'between_tools'}
 */
final class BetaThinkingConfigBetweenTools implements BaseModel
{
    /** @use SdkModel<BetaThinkingConfigBetweenToolsShape> */
    use SdkModel;

    /** @var 'between_tools' $type */
    #[Required(type: new ConstantOf('between_tools'))]
    public string $type = 'between_tools';

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
     * @param 'between_tools' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
