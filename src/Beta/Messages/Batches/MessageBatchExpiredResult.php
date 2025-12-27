<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\Batches;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type MessageBatchExpiredResultShape = array{type: 'expired'}
 */
final class MessageBatchExpiredResult implements BaseModel
{
    /** @use SdkModel<MessageBatchExpiredResultShape> */
    use SdkModel;

    /** @var 'expired' $type */
    #[Required]
    public string $type = 'expired';

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
