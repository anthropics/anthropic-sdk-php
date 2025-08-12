<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\Batches;

use Anthropic\Beta\BetaErrorResponse;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type message_batch_errored_result_alias = array{
 *   error: BetaErrorResponse, type: string
 * }
 */
final class MessageBatchErroredResult implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'errored';

    #[Api]
    public BetaErrorResponse $error;

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
    public static function new(BetaErrorResponse $error): self
    {
        $obj = new self;

        $obj->error = $error;

        return $obj;
    }

    public function setError(BetaErrorResponse $error): self
    {
        $this->error = $error;

        return $this;
    }
}
