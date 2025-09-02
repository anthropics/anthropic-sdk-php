<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_bash_code_execution_result_block = array{
 *   content: list<BetaBashCodeExecutionOutputBlock>,
 *   returnCode: int,
 *   stderr: string,
 *   stdout: string,
 *   type: string,
 * }
 */
final class BetaBashCodeExecutionResultBlock implements BaseModel
{
    /** @use SdkModel<beta_bash_code_execution_result_block> */
    use SdkModel;

    #[Api]
    public string $type = 'bash_code_execution_result';

    /** @var list<BetaBashCodeExecutionOutputBlock> $content */
    #[Api(list: BetaBashCodeExecutionOutputBlock::class)]
    public array $content;

    #[Api('return_code')]
    public int $returnCode;

    #[Api]
    public string $stderr;

    #[Api]
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
     * @param list<BetaBashCodeExecutionOutputBlock> $content
     */
    public static function with(
        array $content,
        int $returnCode,
        string $stderr,
        string $stdout
    ): self {
        $obj = new self;

        $obj->content = $content;
        $obj->returnCode = $returnCode;
        $obj->stderr = $stderr;
        $obj->stdout = $stdout;

        return $obj;
    }

    /**
     * @param list<BetaBashCodeExecutionOutputBlock> $content
     */
    public function withContent(array $content): self
    {
        $obj = clone $this;
        $obj->content = $content;

        return $obj;
    }

    public function withReturnCode(int $returnCode): self
    {
        $obj = clone $this;
        $obj->returnCode = $returnCode;

        return $obj;
    }

    public function withStderr(string $stderr): self
    {
        $obj = clone $this;
        $obj->stderr = $stderr;

        return $obj;
    }

    public function withStdout(string $stdout): self
    {
        $obj = clone $this;
        $obj->stdout = $stdout;

        return $obj;
    }
}
