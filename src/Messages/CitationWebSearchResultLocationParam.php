<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type CitationWebSearchResultLocationParamShape = array{
 *   citedText: string,
 *   encryptedIndex: string,
 *   title: string|null,
 *   type: 'web_search_result_location',
 *   url: string,
 * }
 */
final class CitationWebSearchResultLocationParam implements BaseModel
{
    /** @use SdkModel<CitationWebSearchResultLocationParamShape> */
    use SdkModel;

    /** @var 'web_search_result_location' $type */
    #[Required]
    public string $type = 'web_search_result_location';

    #[Required('cited_text')]
    public string $citedText;

    #[Required('encrypted_index')]
    public string $encryptedIndex;

    #[Required]
    public ?string $title;

    #[Required]
    public string $url;

    /**
     * `new CitationWebSearchResultLocationParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CitationWebSearchResultLocationParam::with(
     *   citedText: ..., encryptedIndex: ..., title: ..., url: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CitationWebSearchResultLocationParam)
     *   ->withCitedText(...)
     *   ->withEncryptedIndex(...)
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
        string $citedText,
        string $encryptedIndex,
        ?string $title,
        string $url
    ): self {
        $self = new self;

        $self['citedText'] = $citedText;
        $self['encryptedIndex'] = $encryptedIndex;
        $self['title'] = $title;
        $self['url'] = $url;

        return $self;
    }

    public function withCitedText(string $citedText): self
    {
        $self = clone $this;
        $self['citedText'] = $citedText;

        return $self;
    }

    public function withEncryptedIndex(string $encryptedIndex): self
    {
        $self = clone $this;
        $self['encryptedIndex'] = $encryptedIndex;

        return $self;
    }

    public function withTitle(?string $title): self
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
