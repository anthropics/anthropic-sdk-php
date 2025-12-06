<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaBashCodeExecutionResultBlockParamShape = array{
 *   content: list<BetaBashCodeExecutionOutputBlockParam>,
 *   return_code: int,
 *   stderr: string,
 *   stdout: string,
 *   type: 'bash_code_execution_result',
 * }
 */
final class BetaBashCodeExecutionResultBlockParam implements BaseModel
{
    /** @use SdkModel<BetaBashCodeExecutionResultBlockParamShape> */
    use SdkModel;

    /** @var 'bash_code_execution_result' $type */
    #[Api]
    public string $type = 'bash_code_execution_result';

    /** @var list<BetaBashCodeExecutionOutputBlockParam> $content */
    #[Api(list: BetaBashCodeExecutionOutputBlockParam::class)]
    public array $content;

    #[Api]
    public int $return_code;

    #[Api]
    public string $stderr;

    #[Api]
    public string $stdout;

    /**
     * `new BetaBashCodeExecutionResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaBashCodeExecutionResultBlockParam::with(
     *   content: ..., return_code: ..., stderr: ..., stdout: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaBashCodeExecutionResultBlockParam)
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
     * @param list<BetaBashCodeExecutionOutputBlockParam|array{
     *   file_id: string, type: 'bash_code_execution_output'
     * }> $content
     */
    public static function with(
        array $content,
        int $return_code,
        string $stderr,
        string $stdout
    ): self {
        $obj = new self;

        $obj['content'] = $content;
        $obj['return_code'] = $return_code;
        $obj['stderr'] = $stderr;
        $obj['stdout'] = $stdout;

        return $obj;
    }

    /**
     * @param list<BetaBashCodeExecutionOutputBlockParam|array{
     *   file_id: string, type: 'bash_code_execution_output'
     * }> $content
     */
    public function withContent(array $content): self
    {
        $obj = clone $this;
        $obj['content'] = $content;

        return $obj;
    }

    public function withReturnCode(int $returnCode): self
    {
        $obj = clone $this;
        $obj['return_code'] = $returnCode;

        return $obj;
    }

    public function withStderr(string $stderr): self
    {
        $obj = clone $this;
        $obj['stderr'] = $stderr;

        return $obj;
    }

    public function withStdout(string $stdout): self
    {
        $obj = clone $this;
        $obj['stdout'] = $stdout;

        return $obj;
    }
}
