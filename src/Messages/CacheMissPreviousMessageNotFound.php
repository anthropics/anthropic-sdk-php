<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type CacheMissPreviousMessageNotFoundShape = array{
 *   type: 'previous_message_not_found'
 * }
 */
final class CacheMissPreviousMessageNotFound implements BaseModel
{
    /** @use SdkModel<CacheMissPreviousMessageNotFoundShape> */
    use SdkModel;

    /** @var 'previous_message_not_found' $type */
    #[Required(type: new ConstantOf('previous_message_not_found'))]
    public string $type = 'previous_message_not_found';

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
     * @param 'previous_message_not_found' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
