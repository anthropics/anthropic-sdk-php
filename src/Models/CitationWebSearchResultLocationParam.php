<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class CitationWebSearchResultLocationParam implements BaseModel
{
    use Model;

    #[Api('cited_text')]
    public string $citedText;

    #[Api('encrypted_index')]
    public string $encryptedIndex;

    #[Api]
    public ?string $title;

    #[Api]
    public string $type;

    #[Api]
    public string $url;

    /**
     * @param string      $citedText
     * @param string      $encryptedIndex
     * @param null|string $title
     * @param string      $type
     * @param string      $url
     */
    final public function __construct(
        $citedText,
        $encryptedIndex,
        $title,
        $type,
        $url
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

CitationWebSearchResultLocationParam::_loadMetadata();
