<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * `messages` holds no `user` or `assistant` content to summarize or adopt.
 *
 * @phpstan-type CompactionNothingToSummarizeErrorDetailsShape = array{
 *   errorCode: 'compaction_nothing_to_summarize'
 * }
 */
final class CompactionNothingToSummarizeErrorDetails implements BaseModel
{
    /** @use SdkModel<CompactionNothingToSummarizeErrorDetailsShape> */
    use SdkModel;

    /** @var 'compaction_nothing_to_summarize' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('compaction_nothing_to_summarize')
    )]
    public string $errorCode = 'compaction_nothing_to_summarize';

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
     * @param 'compaction_nothing_to_summarize' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
