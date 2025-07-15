<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaMessage;

final class BetaMessageBatchSucceededResult implements BaseModel
{
    use Model;

    #[Api]
    public BetaMessage $message;

    #[Api]
    public string $type = 'succeeded';

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param BetaMessage $message `required`
     * @param string      $type    `required`
     */
    final public function __construct($message, $type = 'succeeded')
    {
        $this->constructFromArgs(func_get_args());
    }
}

BetaMessageBatchSucceededResult::_loadMetadata();
