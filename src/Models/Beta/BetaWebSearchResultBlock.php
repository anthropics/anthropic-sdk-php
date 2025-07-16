<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaWebSearchResultBlock implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'web_search_result';

    #[Api('encrypted_content')]
    public string $encryptedContent;

    #[Api('page_age')]
    public ?string $pageAge;

    #[Api]
    public string $title;

    #[Api]
    public string $url;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        string $encryptedContent,
        ?string $pageAge,
        string $title,
        string $url
    ) {
        $this->encryptedContent = $encryptedContent;
        $this->pageAge = $pageAge;
        $this->title = $title;
        $this->url = $url;
    }
}

BetaWebSearchResultBlock::__introspect();
