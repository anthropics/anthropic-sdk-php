<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Claude replies only when it is @-mentioned.
 *
 * @phpstan-type ClaudeTagReplyModeMentionOnlyShape = array{type: 'mention_only'}
 */
final class ClaudeTagReplyModeMentionOnly implements BaseModel
{
    /** @use SdkModel<ClaudeTagReplyModeMentionOnlyShape> */
    use SdkModel;

    /** @var 'mention_only' $type */
    #[Required(type: new ConstantOf('mention_only'))]
    public string $type = 'mention_only';

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
     * @param 'mention_only' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
