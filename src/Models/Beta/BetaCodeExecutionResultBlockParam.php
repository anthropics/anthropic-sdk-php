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
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param list<BetaCodeExecutionOutputBlockParam> $content    `required`
     * @param int                                     $returnCode `required`
     * @param string                                  $stderr     `required`
     * @param string                                  $stdout     `required`
     * @param string                                  $type       `required`
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
