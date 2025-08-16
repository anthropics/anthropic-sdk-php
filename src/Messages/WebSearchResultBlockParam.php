<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type web_search_result_block_param_alias = array{
 *   encryptedContent: string,
 *   title: string,
 *   type: string,
 *   url: string,
 *   pageAge?: string|null,
 * }
 */
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
     * `new WebSearchResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WebSearchResultBlockParam::with(encryptedContent: ..., title: ..., url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WebSearchResultBlockParam)
     *   ->withEncryptedContent(...)
     *   ->withTitle(...)
     *   ->withURL(...)
     * ```
     */
    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        string $encryptedContent,
        string $title,
        string $url,
        ?string $pageAge = null,
    ): self {
        $obj = new self;

        $obj->encryptedContent = $encryptedContent;
        $obj->title = $title;
        $obj->url = $url;

        null !== $pageAge && $obj->pageAge = $pageAge;

        return $obj;
    }

    public function withEncryptedContent(string $encryptedContent): self
    {
        $obj = clone $this;
        $obj->encryptedContent = $encryptedContent;

        return $obj;
    }

    public function withTitle(string $title): self
    {
        $obj = clone $this;
        $obj->title = $title;

        return $obj;
    }

    public function withURL(string $url): self
    {
        $obj = clone $this;
        $obj->url = $url;

        return $obj;
    }

    public function withPageAge(?string $pageAge): self
    {
        $obj = clone $this;
        $obj->pageAge = $pageAge;

        return $obj;
    }
}
