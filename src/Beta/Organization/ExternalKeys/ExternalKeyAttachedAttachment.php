<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalKeys;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type ExternalKeyAttachedAttachmentShape = array{type: 'attached'}
 */
final class ExternalKeyAttachedAttachment implements BaseModel
{
    /** @use SdkModel<ExternalKeyAttachedAttachmentShape> */
    use SdkModel;

    /** @var 'attached' $type */
    #[Required]
    public string $type = 'attached';

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
     * @param 'attached' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
