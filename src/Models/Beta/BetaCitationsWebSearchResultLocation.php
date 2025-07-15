<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaCitationsWebSearchResultLocation implements BaseModel
{
    use Model;

    #[Api('cited_text')]
    public string $citedText;

    #[Api('encrypted_index')]
    public string $encryptedIndex;

    #[Api]
    public ?string $title;

    #[Api]
    public string $type = 'web_search_result_location';

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
        $url,
        $type = 'web_search_result_location',
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

BetaCitationsWebSearchResultLocation::_loadMetadata();
