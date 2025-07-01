<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;

class BetaContainer implements BaseModel
{
    use Model;

    #[Api]
    public string $id;

    #[Api('expires_at')]
    public \DateTimeInterface $expiresAt;

    final public function __construct(string $id, \DateTimeInterface $expiresAt)
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

BetaContainer::_loadMetadata();
