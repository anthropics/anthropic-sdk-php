<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class BetaWebSearchResultBlock implements BaseModel
{
    use Model;

    #[Api('encrypted_content')]
    public string $encryptedContent;

    #[Api('page_age')]
    public ?string $pageAge;

    #[Api]
    public string $title;

    #[Api]
    public string $type;

    #[Api]
    public string $url;

    /**
     * @param string      $encryptedContent
     * @param null|string $pageAge
     * @param string      $title
     * @param string      $type
     * @param string      $url
     */
    final public function __construct(
        $encryptedContent,
        $pageAge,
        $title,
        $type,
        $url
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

BetaWebSearchResultBlock::_loadMetadata();
