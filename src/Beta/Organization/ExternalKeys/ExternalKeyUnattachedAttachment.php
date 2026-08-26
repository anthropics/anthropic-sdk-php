<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalKeys;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type ExternalKeyUnattachedAttachmentShape = array{type: 'unattached'}
 */
final class ExternalKeyUnattachedAttachment implements BaseModel
{
    /** @use SdkModel<ExternalKeyUnattachedAttachmentShape> */
    use SdkModel;

    /** @var 'unattached' $type */
    #[Required]
    public string $type = 'unattached';

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
     * @param 'unattached' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
