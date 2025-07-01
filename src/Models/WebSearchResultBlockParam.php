<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;

class WebSearchResultBlockParam implements BaseModel
{
    use Model;

    #[Api('encrypted_content')]
    public string $encryptedContent;

    #[Api]
    public string $title;

    #[Api]
    public string $type;

    #[Api]
    public string $url;

    #[Api('page_age', optional: true)]
    public ?string $pageAge;

    /**
     * @param null|string $pageAge
     */
    final public function __construct(
        string $encryptedContent,
        string $title,
        string $type,
        string $url,
        null|None|string $pageAge = None::NOT_SET
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

WebSearchResultBlockParam::_loadMetadata();
