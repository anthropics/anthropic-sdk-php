<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ListOf;

/**
 * @phpstan-type beta_code_execution_result_block_param_alias = array{
 *   content: list<BetaCodeExecutionOutputBlockParam>,
 *   returnCode: int,
 *   stderr: string,
 *   stdout: string,
 *   type: string,
 * }
 */
final class BetaCodeExecutionResultBlockParam implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'code_execution_result';

    /** @var list<BetaCodeExecutionOutputBlockParam> $content */
    #[Api(type: new ListOf(BetaCodeExecutionOutputBlockParam::class))]
    public array $content;

    #[Api('return_code')]
    public int $returnCode;

    #[Api]
    public string $stderr;

    #[Api]
    public string $stdout;

    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<BetaCodeExecutionOutputBlockParam> $content
     */
    public static function new(
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
    public function setContent(array $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function setReturnCode(int $returnCode): self
    {
        $this->returnCode = $returnCode;

        return $this;
    }

    public function setStderr(string $stderr): self
    {
        $this->stderr = $stderr;

        return $this;
    }

    public function setStdout(string $stdout): self
    {
        $this->stdout = $stdout;

        return $this;
    }
}
