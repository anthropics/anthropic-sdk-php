<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type BetaCodeExecutionOutputBlockShape from \Anthropic\Beta\Messages\BetaCodeExecutionOutputBlock
 *
 * @phpstan-type BetaCodeExecutionResultBlockShape = array{
 *   content: list<BetaCodeExecutionOutputBlockShape>,
 *   returnCode: int,
 *   stderr: string,
 *   stdout: string,
 *   type: 'code_execution_result',
 * }
 */
final class BetaCodeExecutionResultBlock implements BaseModel
{
    /** @use SdkModel<BetaCodeExecutionResultBlockShape> */
    use SdkModel;

    /** @var 'code_execution_result' $type */
    #[Required]
    public string $type = 'code_execution_result';

    /** @var list<BetaCodeExecutionOutputBlock> $content */
    #[Required(list: BetaCodeExecutionOutputBlock::class)]
    public array $content;

    #[Required('return_code')]
    public int $returnCode;

    #[Required]
    public string $stderr;

    #[Required]
    public string $stdout;

    /**
     * `new BetaCodeExecutionResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaCodeExecutionResultBlock::with(
     *   content: ..., returnCode: ..., stderr: ..., stdout: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaCodeExecutionResultBlock)
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
     * @param list<BetaCodeExecutionOutputBlockShape> $content
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
     * @param list<BetaCodeExecutionOutputBlockShape> $content
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
