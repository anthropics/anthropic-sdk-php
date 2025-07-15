<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class WebSearchResultBlock implements BaseModel
{
    use Model;

    #[Api('encrypted_content')]
    public string $encryptedContent;

    #[Api('page_age')]
    public ?string $pageAge;

    #[Api]
    public string $title;

    #[Api]
    public string $type = 'web_search_result';

    #[Api]
    public string $url;

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param string      $encryptedContent `required`
     * @param null|string $pageAge          `required`
     * @param string      $title            `required`
     * @param string      $type             `required`
     * @param string      $url              `required`
     */
    final public function __construct(
        $encryptedContent,
        $pageAge,
        $title,
        $url,
        $type = 'web_search_result'
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

WebSearchResultBlock::_loadMetadata();
