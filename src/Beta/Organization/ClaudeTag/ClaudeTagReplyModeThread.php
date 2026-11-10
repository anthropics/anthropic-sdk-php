<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Every new top-level message in the channel gets its own reply from Claude, in a thread under it. Available where it is enabled for the channel, and only once Claude has been used in the channel.
 *
 * @phpstan-type ClaudeTagReplyModeThreadShape = array{type: 'thread'}
 */
final class ClaudeTagReplyModeThread implements BaseModel
{
    /** @use SdkModel<ClaudeTagReplyModeThreadShape> */
    use SdkModel;

    /** @var 'thread' $type */
    #[Required(type: new ConstantOf('thread'))]
    public string $type = 'thread';

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
     * @param 'thread' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
