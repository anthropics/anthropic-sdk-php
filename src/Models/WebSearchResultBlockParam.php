<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class WebSearchResultBlockParam implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'web_search_result';

    #[Api('encrypted_content')]
    public string $encryptedContent;

    #[Api]
    public string $title;

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
        string $url,
        ?string $pageAge = null,
    ) {
        $this->encryptedContent = $encryptedContent;
        $this->title = $title;
        $this->url = $url;

        self::_introspect();
        $this->unsetOptionalProperties();

        null !== $pageAge && $this->pageAge = $pageAge;
    }
}
