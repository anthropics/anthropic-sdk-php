<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * No settings level sets a value, and the built-in default applies.
 *
 * @phpstan-type ClaudeTagDefaultSettingSourceShape = array{type: 'default'}
 */
final class ClaudeTagDefaultSettingSource implements BaseModel
{
    /** @use SdkModel<ClaudeTagDefaultSettingSourceShape> */
    use SdkModel;

    /** @var 'default' $type */
    #[Required(type: new ConstantOf('default'))]
    public string $type = 'default';

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
     * @param 'default' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
