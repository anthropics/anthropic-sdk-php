<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The `compaction` block's `content` differs from the text its `signature` recorded.
 *
 * @phpstan-type CompactionContentMismatchErrorDetailsShape = array{
 *   errorCode: 'compaction_content_mismatch'
 * }
 */
final class CompactionContentMismatchErrorDetails implements BaseModel
{
    /** @use SdkModel<CompactionContentMismatchErrorDetailsShape> */
    use SdkModel;

    /** @var 'compaction_content_mismatch' $errorCode */
    #[Required('error_code', type: new ConstantOf('compaction_content_mismatch'))]
    public string $errorCode = 'compaction_content_mismatch';

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
     * @param 'compaction_content_mismatch' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
