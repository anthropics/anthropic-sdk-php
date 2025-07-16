<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\WebSearchResultBlock\Type;

final class WebSearchResultBlock implements BaseModel
{
    use Model;

    #[Api('encrypted_content')]
    public string $encryptedContent;

    #[Api('page_age')]
    public ?string $pageAge;

    #[Api]
    public string $title;

    /** @var Type::* $type */
    #[Api]
    public string $type = 'web_search_result';

    #[Api]
    public string $url;

    /**
     * You must use named parameters to construct this object.
     *
     * @param Type::* $type
     */
    final public function __construct(
        string $encryptedContent,
        ?string $pageAge,
        string $title,
        string $url,
        string $type = 'web_search_result',
    ) {
        $this->encryptedContent = $encryptedContent;
        $this->pageAge = $pageAge;
        $this->title = $title;
        $this->type = $type;
        $this->url = $url;
    }
}

WebSearchResultBlock::_loadMetadata();
