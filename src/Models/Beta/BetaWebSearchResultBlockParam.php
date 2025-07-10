<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;

class BetaWebSearchResultBlockParam implements BaseModel
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
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param string      $encryptedContent `required`
     * @param string      $title            `required`
     * @param string      $type             `required`
     * @param string      $url              `required`
     * @param null|string $pageAge
     */
    final public function __construct(
        $encryptedContent,
        $title,
        $type,
        $url,
        $pageAge = None::NOT_GIVEN
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

BetaWebSearchResultBlockParam::_loadMetadata();
