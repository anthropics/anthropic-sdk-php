<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaCacheMissPreviousMessageNotFoundShape = array{
 *   type: 'previous_message_not_found'
 * }
 */
final class BetaCacheMissPreviousMessageNotFound implements BaseModel
{
    /** @use SdkModel<BetaCacheMissPreviousMessageNotFoundShape> */
    use SdkModel;

    /** @var 'previous_message_not_found' $type */
    #[Required]
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
