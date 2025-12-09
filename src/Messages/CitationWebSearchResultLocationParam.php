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
 *   type?: 'web_search_result_location',
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
        $obj = new self;

        $obj['citedText'] = $citedText;
        $obj['encryptedIndex'] = $encryptedIndex;
        $obj['title'] = $title;
        $obj['url'] = $url;

        return $obj;
    }

    public function withCitedText(string $citedText): self
    {
        $obj = clone $this;
        $obj['citedText'] = $citedText;

        return $obj;
    }

    public function withEncryptedIndex(string $encryptedIndex): self
    {
        $obj = clone $this;
        $obj['encryptedIndex'] = $encryptedIndex;

        return $obj;
    }

    public function withTitle(?string $title): self
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
