<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\None;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class BetaCitationsDelta implements BaseModel
{
    use Model;

    /**
     * @var BetaCitationCharLocation|BetaCitationPageLocation|BetaCitationContentBlockLocation|BetaCitationsWebSearchResultLocation $citation
     */
    #[Api]
    public mixed $citation;

    #[Api]
    public string $type;

    /**
     * @param BetaCitationCharLocation|BetaCitationPageLocation|BetaCitationContentBlockLocation|BetaCitationsWebSearchResultLocation $citation
     */
    final public function __construct(mixed $citation, string $type)
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

BetaCitationsDelta::_loadMetadata();
