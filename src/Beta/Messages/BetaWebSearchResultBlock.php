<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaWebSearchResultBlockShape = array{
 *   encryptedContent: string,
 *   pageAge: string|null,
 *   title: string,
 *   type?: 'web_search_result',
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

    #[Required('encrypted_content')]
    public string $encryptedContent;

    #[Required('page_age')]
    public ?string $pageAge;

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
     *   encryptedContent: ..., pageAge: ..., title: ..., url: ...
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
        string $encryptedContent,
        ?string $pageAge,
        string $title,
        string $url
    ): self {
        $self = new self;

        $self['encryptedContent'] = $encryptedContent;
        $self['pageAge'] = $pageAge;
        $self['title'] = $title;
        $self['url'] = $url;

        return $self;
    }

    public function withEncryptedContent(string $encryptedContent): self
    {
        $self = clone $this;
        $self['encryptedContent'] = $encryptedContent;

        return $self;
    }

    public function withPageAge(?string $pageAge): self
    {
        $self = clone $this;
        $self['pageAge'] = $pageAge;

        return $self;
    }

    public function withTitle(string $title): self
    {
        $self = clone $this;
        $self['title'] = $title;

        return $self;
    }

    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
