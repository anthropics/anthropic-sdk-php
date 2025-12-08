<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaCodeExecutionResultBlockParamShape = array{
 *   content: list<BetaCodeExecutionOutputBlockParam>,
 *   return_code: int,
 *   stderr: string,
 *   stdout: string,
 *   type: 'code_execution_result',
 * }
 */
final class BetaCodeExecutionResultBlockParam implements BaseModel
{
    /** @use SdkModel<BetaCodeExecutionResultBlockParamShape> */
    use SdkModel;

    /** @var 'code_execution_result' $type */
    #[Required]
    public string $type = 'code_execution_result';

    /** @var list<BetaCodeExecutionOutputBlockParam> $content */
    #[Required(list: BetaCodeExecutionOutputBlockParam::class)]
    public array $content;

    #[Required]
    public int $return_code;

    #[Required]
    public string $stderr;

    #[Required]
    public string $stdout;

    /**
     * `new BetaCodeExecutionResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaCodeExecutionResultBlockParam::with(
     *   content: ..., return_code: ..., stderr: ..., stdout: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaCodeExecutionResultBlockParam)
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
     * @param list<BetaCodeExecutionOutputBlockParam|array{
     *   file_id: string, type: 'code_execution_output'
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
     * @param list<BetaCodeExecutionOutputBlockParam|array{
     *   file_id: string, type: 'code_execution_output'
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
