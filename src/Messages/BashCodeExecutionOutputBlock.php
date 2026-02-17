<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BashCodeExecutionOutputBlockShape = array{
 *   fileID: string, type: 'bash_code_execution_output'
 * }
 */
final class BashCodeExecutionOutputBlock implements BaseModel
{
    /** @use SdkModel<BashCodeExecutionOutputBlockShape> */
    use SdkModel;

    /** @var 'bash_code_execution_output' $type */
    #[Required]
    public string $type = 'bash_code_execution_output';

    #[Required('file_id')]
    public string $fileID;

    /**
     * `new BashCodeExecutionOutputBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BashCodeExecutionOutputBlock::with(fileID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BashCodeExecutionOutputBlock)->withFileID(...)
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

    /**
     * @param 'bash_code_execution_output' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
