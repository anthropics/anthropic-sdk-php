<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The value comes from the organization's Slack defaults, which have no identifier.
 *
 * @phpstan-type ClaudeTagSlackDefaultSettingSourceShape = array{
 *   type: 'slack_default'
 * }
 */
final class ClaudeTagSlackDefaultSettingSource implements BaseModel
{
    /** @use SdkModel<ClaudeTagSlackDefaultSettingSourceShape> */
    use SdkModel;

    /** @var 'slack_default' $type */
    #[Required(type: new ConstantOf('slack_default'))]
    public string $type = 'slack_default';

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
     * @param 'slack_default' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
