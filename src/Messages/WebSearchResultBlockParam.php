<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type WebSearchResultBlockParamShape = array{
 *   encrypted_content: string,
 *   title: string,
 *   type: 'web_search_result',
 *   url: string,
 *   page_age?: string|null,
 * }
 */
final class WebSearchResultBlockParam implements BaseModel
{
    /** @use SdkModel<WebSearchResultBlockParamShape> */
    use SdkModel;

    /** @var 'web_search_result' $type */
    #[Api]
    public string $type = 'web_search_result';

    #[Api]
    public string $encrypted_content;

    #[Api]
    public string $title;

    #[Api]
    public string $url;

    #[Api(nullable: true, optional: true)]
    public ?string $page_age;

    /**
     * `new WebSearchResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WebSearchResultBlockParam::with(encrypted_content: ..., title: ..., url: ...)
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
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        string $encrypted_content,
        string $title,
        string $url,
        ?string $page_age = null,
    ): self {
        $obj = new self;

        $obj['encrypted_content'] = $encrypted_content;
        $obj['title'] = $title;
        $obj['url'] = $url;

        null !== $page_age && $obj['page_age'] = $page_age;

        return $obj;
    }

    public function withEncryptedContent(string $encryptedContent): self
    {
        $obj = clone $this;
        $obj['encrypted_content'] = $encryptedContent;

        return $obj;
    }

    public function withTitle(string $title): self
    {
        $obj = clone $this;
        $obj['title'] = $title;

        return $obj;
    }

    public function withURL(string $url): self
    {
        $obj = clone $this;
        $obj['url'] = $url;

        return $obj;
    }

    public function withPageAge(?string $pageAge): self
    {
        $obj = clone $this;
        $obj['page_age'] = $pageAge;

        return $obj;
    }
}
