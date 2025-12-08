<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaWebSearchResultBlockShape = array{
 *   encrypted_content: string,
 *   page_age: string|null,
 *   title: string,
 *   type: 'web_search_result',
 *   url: string,
 * }
 */
final class BetaWebSearchResultBlock implements BaseModel
{
    /** @use SdkModel<BetaWebSearchResultBlockShape> */
    use SdkModel;

    /** @var 'web_search_result' $type */
    #[Required]
    public string $type = 'web_search_result';

    #[Required]
    public string $encrypted_content;

    #[Required]
    public ?string $page_age;

    #[Required]
    public string $title;

    #[Required]
    public string $url;

    /**
     * `new BetaWebSearchResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaWebSearchResultBlock::with(
     *   encrypted_content: ..., page_age: ..., title: ..., url: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaWebSearchResultBlock)
     *   ->withEncryptedContent(...)
     *   ->withPageAge(...)
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
        ?string $page_age,
        string $title,
        string $url
    ): self {
        $obj = new self;

        $obj['encrypted_content'] = $encrypted_content;
        $obj['page_age'] = $page_age;
        $obj['title'] = $title;
        $obj['url'] = $url;

        return $obj;
    }

    public function withEncryptedContent(string $encryptedContent): self
    {
        $obj = clone $this;
        $obj['encrypted_content'] = $encryptedContent;

        return $obj;
    }

    public function withPageAge(?string $pageAge): self
    {
        $obj = clone $this;
        $obj['page_age'] = $pageAge;

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
}
