<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\CitationWebSearchResultLocationParam\Type;

final class CitationWebSearchResultLocationParam implements BaseModel
{
    use Model;

    #[Api('cited_text')]
    public string $citedText;

    #[Api('encrypted_index')]
    public string $encryptedIndex;

    #[Api]
    public ?string $title;

    /** @var Type::* $type */
    #[Api]
    public string $type;

    #[Api]
    public string $url;

    /**
     * You must use named parameters to construct this object.
     *
     * @param Type::* $type
     */
    final public function __construct(
        string $citedText,
        string $encryptedIndex,
        ?string $title,
        string $type,
        string $url,
    ) {
        $this->citedText = $citedText;
        $this->encryptedIndex = $encryptedIndex;
        $this->title = $title;
        $this->type = $type;
        $this->url = $url;
    }
}

CitationWebSearchResultLocationParam::_loadMetadata();
