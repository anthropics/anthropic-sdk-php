<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\None;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class DeletedFile implements BaseModel
{
    use Model;

    #[Api]
    public string $id;

    #[Api(optional: true)]
    public string $type;

    /**
     * @param string $type
     */
    final public function __construct(
        string $id,
        string|None $type = None::NOT_SET,
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

DeletedFile::_loadMetadata();
