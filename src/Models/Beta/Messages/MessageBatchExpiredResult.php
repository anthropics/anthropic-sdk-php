<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type message_batch_expired_result_alias = array{type: string}
 */
final class MessageBatchExpiredResult implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'expired';

    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function new(): self
    {
        return new self;
    }
}
