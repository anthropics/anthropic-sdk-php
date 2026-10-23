<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Claude does not answer in the channel.
 *
 * @phpstan-type ClaudeTagGuestPolicyRestrictShape = array{type: 'restrict'}
 */
final class ClaudeTagGuestPolicyRestrict implements BaseModel
{
    /** @use SdkModel<ClaudeTagGuestPolicyRestrictShape> */
    use SdkModel;

    /** @var 'restrict' $type */
    #[Required(type: new ConstantOf('restrict'))]
    public string $type = 'restrict';

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
     * @param 'restrict' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
