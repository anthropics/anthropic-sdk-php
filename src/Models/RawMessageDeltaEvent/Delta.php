<?php

declare(strict_types=1);

namespace Anthropic\Models\RawMessageDeltaEvent;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class Delta implements BaseModel
{
    use Model;

    #[Api('stop_reason')]
    public string $stopReason;

    #[Api('stop_sequence')]
    public ?string $stopSequence;

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param string      $stopReason   `required`
     * @param null|string $stopSequence `required`
     */
    final public function __construct($stopReason, $stopSequence)
    {
        $this->constructFromArgs(func_get_args());
    }
}

Delta::_loadMetadata();
