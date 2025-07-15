<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class WebSearchResultBlockParam implements BaseModel
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
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        string $encryptedContent,
        string $title,
        string $type,
        string $url,
        ?string $pageAge = null,
    ) {
        $this->encryptedContent = $encryptedContent;
        $this->title = $title;
        $this->type = $type;
        $this->url = $url;
        $this->pageAge = $pageAge;
    }
}

WebSearchResultBlockParam::_loadMetadata();
