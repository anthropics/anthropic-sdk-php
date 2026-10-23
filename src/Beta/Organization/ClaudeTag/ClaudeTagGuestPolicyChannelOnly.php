<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Claude answers with only the Bundles attached to the channel itself.
 *
 * @phpstan-type ClaudeTagGuestPolicyChannelOnlyShape = array{type: 'channel_only'}
 */
final class ClaudeTagGuestPolicyChannelOnly implements BaseModel
{
    /** @use SdkModel<ClaudeTagGuestPolicyChannelOnlyShape> */
    use SdkModel;

    /** @var 'channel_only' $type */
    #[Required(type: new ConstantOf('channel_only'))]
    public string $type = 'channel_only';

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
     * @param 'channel_only' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
