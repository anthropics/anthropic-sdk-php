<?php

declare(strict_types=1);

namespace Anthropic\Messages\Batches;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type message_batch_canceled_result = array{type: string}
 */
final class MessageBatchCanceledResult implements BaseModel
{
    /** @use SdkModel<message_batch_canceled_result> */
    use SdkModel;

    #[Api]
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
