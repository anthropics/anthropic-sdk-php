<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type BetaBashCodeExecutionOutputBlockShape from \Anthropic\Beta\Messages\BetaBashCodeExecutionOutputBlock
 *
 * @phpstan-type BetaBashCodeExecutionResultBlockShape = array{
 *   content: list<BetaBashCodeExecutionOutputBlockShape>,
 *   returnCode: int,
 *   stderr: string,
 *   stdout: string,
 *   type: 'bash_code_execution_result',
 * }
 */
final class BetaBashCodeExecutionResultBlock implements BaseModel
{
    /** @use SdkModel<BetaBashCodeExecutionResultBlockShape> */
    use SdkModel;

    /** @var 'bash_code_execution_result' $type */
    #[Required]
    public string $type = 'bash_code_execution_result';

    /** @var list<BetaBashCodeExecutionOutputBlock> $content */
    #[Required(list: BetaBashCodeExecutionOutputBlock::class)]
    public array $content;

    #[Required('return_code')]
    public int $returnCode;

    #[Required]
    public string $stderr;

    #[Required]
    public string $stdout;

    /**
     * `new BetaBashCodeExecutionResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaBashCodeExecutionResultBlock::with(
     *   content: ..., returnCode: ..., stderr: ..., stdout: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaBashCodeExecutionResultBlock)
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
     * @param list<BetaBashCodeExecutionOutputBlockShape> $content
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
     * @param list<BetaBashCodeExecutionOutputBlockShape> $content
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
}
