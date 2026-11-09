<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Like `automatic`, but Claude never pauses on its own. Available where it is enabled for the channel.
 *
 * @phpstan-type ClaudeTagReplyModeAlwaysAwakeShape = array{type: 'always_awake'}
 */
final class ClaudeTagReplyModeAlwaysAwake implements BaseModel
{
    /** @use SdkModel<ClaudeTagReplyModeAlwaysAwakeShape> */
    use SdkModel;

    /** @var 'always_awake' $type */
    #[Required(type: new ConstantOf('always_awake'))]
    public string $type = 'always_awake';

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
     * @param 'always_awake' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
