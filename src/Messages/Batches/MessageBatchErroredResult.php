<?php

declare(strict_types=1);

namespace Anthropic\Messages\Batches;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Shared\ErrorResponse;

/**
 * @phpstan-type message_batch_errored_result_alias = array{
 *   error: ErrorResponse, type: string
 * }
 */
final class MessageBatchErroredResult implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'errored';

    #[Api]
    public ErrorResponse $error;

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
    public static function new(ErrorResponse $error): self
    {
        $obj = new self;

        $obj->error = $error;

        return $obj;
    }

    public function setError(ErrorResponse $error): self
    {
        $this->error = $error;

        return $this;
    }
}
