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
     * @param string      $encryptedContent
     * @param string      $title
     * @param string      $type
     * @param string      $url
     * @param null|string $pageAge
     */
    final public function __construct(
        $encryptedContent,
        $title,
        $type,
        $url,
        $pageAge = None::NOT_GIVEN
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

WebSearchResultBlockParam::_loadMetadata();
