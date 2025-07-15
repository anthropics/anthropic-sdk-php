<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaRawMessageStartEvent implements BaseModel
{
    use Model;

    #[Api]
    public BetaMessage $message;

    #[Api]
    public string $type = 'message_start';

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param BetaMessage $message `required`
     * @param string      $type    `required`
     */
    final public function __construct($message, $type = 'message_start')
    {
        $this->constructFromArgs(func_get_args());
    }
}

BetaRawMessageStartEvent::_loadMetadata();
