<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type BashCodeExecutionOutputBlockParamShape from \Anthropic\Messages\BashCodeExecutionOutputBlockParam
 *
 * @phpstan-type BashCodeExecutionResultBlockParamShape = array{
 *   content: list<BashCodeExecutionOutputBlockParam|BashCodeExecutionOutputBlockParamShape>,
 *   returnCode: int,
 *   stderr: string,
 *   stdout: string,
 *   type: 'bash_code_execution_result',
 * }
 */
final class BashCodeExecutionResultBlockParam implements BaseModel
{
    /** @use SdkModel<BashCodeExecutionResultBlockParamShape> */
    use SdkModel;

    /** @var 'bash_code_execution_result' $type */
    #[Required]
    public string $type = 'bash_code_execution_result';

    /** @var list<BashCodeExecutionOutputBlockParam> $content */
    #[Required(list: BashCodeExecutionOutputBlockParam::class)]
    public array $content;

    #[Required('return_code')]
    public int $returnCode;

    #[Required]
    public string $stderr;

    #[Required]
    public string $stdout;

    /**
     * `new BashCodeExecutionResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BashCodeExecutionResultBlockParam::with(
     *   content: ..., returnCode: ..., stderr: ..., stdout: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BashCodeExecutionResultBlockParam)
     *   ->withContent(...)
     *   ->withReturnCode(...)
     *   ->withStderr(...)
     *   ->withStdout(...)
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
     *
     * @param list<BashCodeExecutionOutputBlockParam|BashCodeExecutionOutputBlockParamShape> $content
     */
    public static function with(
        array $content,
        int $returnCode,
        string $stderr,
        string $stdout
    ): self {
        $self = new self;

        $self['content'] = $content;
        $self['returnCode'] = $returnCode;
        $self['stderr'] = $stderr;
        $self['stdout'] = $stdout;

        return $self;
    }

    /**
     * @param list<BashCodeExecutionOutputBlockParam|BashCodeExecutionOutputBlockParamShape> $content
     */
    public function withContent(array $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    public function withReturnCode(int $returnCode): self
    {
        $self = clone $this;
        $self['returnCode'] = $returnCode;

        return $self;
    }

    public function withStderr(string $stderr): self
    {
        $self = clone $this;
        $self['stderr'] = $stderr;

        return $self;
    }

    public function withStdout(string $stdout): self
    {
        $self = clone $this;
        $self['stdout'] = $stdout;

        return $self;
    }

    /**
     * @param 'bash_code_execution_result' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
