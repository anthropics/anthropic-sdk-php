<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class CitationWebSearchResultLocationParam implements BaseModel
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
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param string      $citedText      `required`
     * @param string      $encryptedIndex `required`
     * @param null|string $title          `required`
     * @param string      $type           `required`
     * @param string      $url            `required`
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
