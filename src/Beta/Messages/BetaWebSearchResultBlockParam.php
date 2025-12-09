<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaWebSearchResultBlockParamShape = array{
 *   encryptedContent: string,
 *   title: string,
 *   type?: 'web_search_result',
 *   url: string,
 *   pageAge?: string|null,
 * }
 */
final class BetaWebSearchResultBlockParam implements BaseModel
{
    /** @use SdkModel<BetaWebSearchResultBlockParamShape> */
    use SdkModel;

    /** @var 'web_search_result' $type */
    #[Required]
    public string $type = 'web_search_result';

    #[Required('encrypted_content')]
    public string $encryptedContent;

    #[Required]
    public string $title;

    #[Required]
    public string $url;

    #[Optional('page_age', nullable: true)]
    public ?string $pageAge;

    /**
     * `new BetaWebSearchResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaWebSearchResultBlockParam::with(encryptedContent: ..., title: ..., url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaWebSearchResultBlockParam)
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
        string $encryptedContent,
        string $title,
        string $url,
        ?string $pageAge = null,
    ): self {
        $obj = new self;

        $obj['encryptedContent'] = $encryptedContent;
        $obj['title'] = $title;
        $obj['url'] = $url;

        null !== $pageAge && $obj['pageAge'] = $pageAge;

        return $obj;
    }

    public function withEncryptedContent(string $encryptedContent): self
    {
        $obj = clone $this;
        $obj['encryptedContent'] = $encryptedContent;

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
        $obj['pageAge'] = $pageAge;

        return $obj;
    }
}
