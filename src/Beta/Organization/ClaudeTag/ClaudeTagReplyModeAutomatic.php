<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Claude reads along and joins in when it can help, and pauses on its own in quiet or busy channels.
 *
 * @phpstan-type ClaudeTagReplyModeAutomaticShape = array{type: 'automatic'}
 */
final class ClaudeTagReplyModeAutomatic implements BaseModel
{
    /** @use SdkModel<ClaudeTagReplyModeAutomaticShape> */
    use SdkModel;

    /** @var 'automatic' $type */
    #[Required(type: new ConstantOf('automatic'))]
    public string $type = 'automatic';

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
     * @param 'automatic' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
