<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The compaction could not be completed for a transient server reason. Retry the request.
 *
 * @phpstan-type CompactionUnavailableErrorDetailsShape = array{
 *   errorCode: 'compaction_unavailable'
 * }
 */
final class CompactionUnavailableErrorDetails implements BaseModel
{
    /** @use SdkModel<CompactionUnavailableErrorDetailsShape> */
    use SdkModel;

    /** @var 'compaction_unavailable' $errorCode */
    #[Required('error_code', type: new ConstantOf('compaction_unavailable'))]
    public string $errorCode = 'compaction_unavailable';

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
     * @param 'compaction_unavailable' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
