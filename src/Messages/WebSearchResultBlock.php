<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type web_search_result_block_alias = array{
 *   encryptedContent: string,
 *   pageAge: string|null,
 *   title: string,
 *   type: string,
 *   url: string,
 * }
 */
final class WebSearchResultBlock implements BaseModel
{
    use ModelTrait;

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
     * `new WebSearchResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WebSearchResultBlock::with(
     *   encryptedContent: ..., pageAge: ..., title: ..., url: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WebSearchResultBlock)
     *   ->withEncryptedContent(...)
     *   ->withPageAge(...)
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
        ?string $pageAge,
        string $title,
        string $url
    ): self {
        $obj = new self;

        $obj->encryptedContent = $encryptedContent;
        $obj->pageAge = $pageAge;
        $obj->title = $title;
        $obj->url = $url;

        return $obj;
    }

    public function withEncryptedContent(string $encryptedContent): self
    {
        $obj = clone $this;
        $obj->encryptedContent = $encryptedContent;

        return $obj;
    }

    public function withPageAge(?string $pageAge): self
    {
        $obj = clone $this;
        $obj->pageAge = $pageAge;

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
}
