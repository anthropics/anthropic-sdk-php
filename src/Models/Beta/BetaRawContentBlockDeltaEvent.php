<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaRawContentBlockDeltaEvent implements BaseModel
{
    use Model;

    #[Api]
    public BetaCitationsDelta|BetaInputJSONDelta|BetaSignatureDelta|BetaTextDelta|BetaThinkingDelta $delta;

    #[Api]
    public int $index;

    #[Api]
    public string $type = 'content_block_delta';

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param BetaCitationsDelta|BetaInputJSONDelta|BetaSignatureDelta|BetaTextDelta|BetaThinkingDelta $delta `required`
     * @param int                                                                                      $index `required`
     * @param string                                                                                   $type  `required`
     */
    final public function __construct(
        $delta,
        $index,
        $type = 'content_block_delta'
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

BetaRawContentBlockDeltaEvent::_loadMetadata();
