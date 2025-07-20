<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

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

    /**
     * You must use named parameters to construct this object.
     *
     * @param list<BetaCodeExecutionOutputBlockParam> $content
     */
    final public function __construct(
        array $content,
        int $returnCode,
        string $stderr,
        string $stdout
    ) {
        self::introspect();

        $this->content = $content;
        $this->returnCode = $returnCode;
        $this->stderr = $stderr;
        $this->stdout = $stdout;
    }
}
