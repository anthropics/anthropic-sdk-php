<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\None;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

class ContentBlockSource implements BaseModel
{
    use Model;

    /**
     * @var string|list<TextBlockParam|ImageBlockParam> $content
     */
    #[Api(
        type: new UnionOf(
            [
                'string',
                new ListOf(
                    new UnionOf([TextBlockParam::class, ImageBlockParam::class])
                ),
            ],
        ),
    )]
    public mixed $content;

    #[Api]
    public string $type;

    /**
     * @param string|list<TextBlockParam|ImageBlockParam> $content
     */
    final public function __construct(mixed $content, string $type)
    {

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

ContentBlockSource::_loadMetadata();
