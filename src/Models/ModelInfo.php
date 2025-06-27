<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\None;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class ModelInfo implements BaseModel
{
    use Model;

    #[Api]
    public string $id;

    #[Api('created_at')]
    public mixed $createdAt;

    #[Api('display_name')]
    public string $displayName;

    #[Api]
    public string $type;

    final public function __construct(
        string $id,
        mixed $createdAt,
        string $displayName,
        string $type,
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

ModelInfo::_loadMetadata();
