<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The compaction request ends on an `assistant` turn that is not finished.
 *
 * @phpstan-type CompactionIncompleteTurnErrorDetailsShape = array{
 *   errorCode: 'compaction_incomplete_turn'
 * }
 */
final class CompactionIncompleteTurnErrorDetails implements BaseModel
{
    /** @use SdkModel<CompactionIncompleteTurnErrorDetailsShape> */
    use SdkModel;

    /** @var 'compaction_incomplete_turn' $errorCode */
    #[Required('error_code', type: new ConstantOf('compaction_incomplete_turn'))]
    public string $errorCode = 'compaction_incomplete_turn';

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

    /**
     * @param 'compaction_incomplete_turn' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
