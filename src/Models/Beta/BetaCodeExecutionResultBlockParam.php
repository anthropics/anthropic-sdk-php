<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;
use Anthropic\Core\Serde\ListOf;

class BetaCodeExecutionResultBlockParam implements BaseModel
{
    use Model;

    /**
     * @var list<BetaCodeExecutionOutputBlockParam> $content
     */
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
     */
    final public function __construct(
        array $content,
        int $returnCode,
        string $stderr,
        string $stdout,
        string $type
    ) {
        $args = func_get_args();

        $data = [];
        for ($i = 0; $i < count($args); ++$i) {
            if (None::NOT_SET !== $args[$i]) {
                $data[self::$_constructorArgNames[$i]] = $args[$i] ?? null;
            }
        }

        $this->__unserialize($data);
    }
}

BetaCodeExecutionResultBlockParam::_loadMetadata();
