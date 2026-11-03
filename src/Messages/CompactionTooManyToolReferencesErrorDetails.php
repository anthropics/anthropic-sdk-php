<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The conversation references more distinct tools than a `compaction` block can record.
 *
 * @phpstan-type CompactionTooManyToolReferencesErrorDetailsShape = array{
 *   errorCode: 'compaction_too_many_tool_references'
 * }
 */
final class CompactionTooManyToolReferencesErrorDetails implements BaseModel
{
    /** @use SdkModel<CompactionTooManyToolReferencesErrorDetailsShape> */
    use SdkModel;

    /** @var 'compaction_too_many_tool_references' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('compaction_too_many_tool_references')
    )]
    public string $errorCode = 'compaction_too_many_tool_references';

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
     * @param 'compaction_too_many_tool_references' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
