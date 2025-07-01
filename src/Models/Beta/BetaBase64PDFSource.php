<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;

class BetaBase64PDFSource implements BaseModel
{
    use Model;

    #[Api]
    public string $data;

    #[Api('media_type')]
    public string $mediaType;

    #[Api]
    public string $type;

    final public function __construct(
        string $data,
        string $mediaType,
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

BetaBase64PDFSource::_loadMetadata();
