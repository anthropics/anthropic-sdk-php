<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

class BetaMCPToolResultBlock implements BaseModel
{
    use Model;

    /**
     * @var list<BetaTextBlock>|string $content
     */
    #[Api(type: new UnionOf(['string', new ListOf(BetaTextBlock::class)]))]
    public mixed $content;

    #[Api('is_error')]
    public bool $isError;

    #[Api('tool_use_id')]
    public string $toolUseID;

    #[Api]
    public string $type;

    /**
     * @param list<BetaTextBlock>|string $content
     */
    final public function __construct(
        mixed $content,
        bool $isError,
        string $toolUseID,
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

BetaMCPToolResultBlock::_loadMetadata();
