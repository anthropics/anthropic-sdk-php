<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;

final class BetaCodeExecutionResultBlockParam implements BaseModel
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
     * You must use named parameters to construct this object.
     *
     * @param list<BetaCodeExecutionOutputBlockParam> $content
     */
    final public function __construct(
        array $content,
        int $returnCode,
        string $stderr,
        string $stdout,
        string $type,
    ) {
        $this->content = $content;
        $this->returnCode = $returnCode;
        $this->stderr = $stderr;
        $this->stdout = $stdout;
        $this->type = $type;
    }
}

BetaCodeExecutionResultBlockParam::_loadMetadata();
