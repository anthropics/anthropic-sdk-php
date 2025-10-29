<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaCodeExecutionResultBlockParamShape = array{
 *   content: list<BetaCodeExecutionOutputBlockParam>,
 *   returnCode: int,
 *   stderr: string,
 *   stdout: string,
 *   type: string,
 * }
 */
final class BetaCodeExecutionResultBlockParam implements BaseModel
{
    /** @use SdkModel<BetaCodeExecutionResultBlockParamShape> */
    use SdkModel;

    #[Api]
    public string $type = 'code_execution_result';

    /** @var list<BetaCodeExecutionOutputBlockParam> $content */
    #[Api(list: BetaCodeExecutionOutputBlockParam::class)]
    public array $content;

    #[Api('return_code')]
    public int $returnCode;

    #[Api]
    public string $stderr;

    #[Api]
    public string $stdout;

    /**
     * `new BetaCodeExecutionResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaCodeExecutionResultBlockParam::with(
     *   content: ..., returnCode: ..., stderr: ..., stdout: ...
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
     * @param list<BetaCodeExecutionOutputBlockParam> $content
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
     * @param list<BetaCodeExecutionOutputBlockParam> $content
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
