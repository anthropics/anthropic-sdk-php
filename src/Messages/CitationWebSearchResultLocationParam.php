<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

final class CitationWebSearchResultLocationParam implements BaseModel
{
    use SdkModel;

    #[Api]
    public string $type = 'web_search_result_location';

    #[Api('cited_text')]
    public string $citedText;

    #[Api('encrypted_index')]
    public string $encryptedIndex;

    #[Api]
    public ?string $title;

    #[Api]
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
        self::introspect();
        $this->unsetOptionalProperties();
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

        $obj->citedText = $citedText;
        $obj->encryptedIndex = $encryptedIndex;
        $obj->title = $title;
        $obj->url = $url;

        return $obj;
    }

    public function withCitedText(string $citedText): self
    {
        $obj = clone $this;
        $obj->citedText = $citedText;

        return $obj;
    }

    public function withEncryptedIndex(string $encryptedIndex): self
    {
        $obj = clone $this;
        $obj->encryptedIndex = $encryptedIndex;

        return $obj;
    }

    public function withTitle(?string $title): self
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
