<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;

class BetaCodeExecutionResultBlockParam implements BaseModel
{
    use Model;

    /** @var list<BetaCodeExecutionOutputBlockParam> $content */
    #[Api(type: new ListOf(BetaCodeExecutionOutputBlockParam::class))]
    public array $content;

    #[Api('return_code')]
    public int $returnCode;

    #[Api]
    public string $stderr;

    #[Api]
    public string $stdout;

    #[Api]
    public string $type;

    /**
     * @param list<BetaCodeExecutionOutputBlockParam> $content
     * @param int                                     $returnCode
     * @param string                                  $stderr
     * @param string                                  $stdout
     * @param string                                  $type
     */
    final public function __construct(
        $content,
        $returnCode,
        $stderr,
        $stdout,
        $type
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

BetaCodeExecutionResultBlockParam::_loadMetadata();
