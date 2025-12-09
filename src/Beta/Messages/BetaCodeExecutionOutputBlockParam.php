<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaCodeExecutionOutputBlockParamShape = array{
 *   fileID: string, type?: 'code_execution_output'
 * }
 */
final class BetaCodeExecutionOutputBlockParam implements BaseModel
{
    /** @use SdkModel<BetaCodeExecutionOutputBlockParamShape> */
    use SdkModel;

    /** @var 'code_execution_output' $type */
    #[Required]
    public string $type = 'code_execution_output';

    #[Required('file_id')]
    public string $fileID;

    /**
     * `new BetaCodeExecutionOutputBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaCodeExecutionOutputBlockParam::with(fileID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaCodeExecutionOutputBlockParam)->withFileID(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(string $fileID): self
    {
        $self = new self;

        $self['fileID'] = $fileID;

        return $self;
    }

    public function withFileID(string $fileID): self
    {
        $self = clone $this;
        $self['fileID'] = $fileID;

        return $self;
    }
}
