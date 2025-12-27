<?php

declare(strict_types=1);

namespace Anthropic\Messages\Batches;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type MessageBatchCanceledResultShape = array{type: 'canceled'}
 */
final class MessageBatchCanceledResult implements BaseModel
{
    /** @use SdkModel<MessageBatchCanceledResultShape> */
    use SdkModel;

    /** @var 'canceled' $type */
    #[Required]
    public string $type = 'canceled';

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
}
