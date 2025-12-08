<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaCitationWebSearchResultLocationParamShape = array{
 *   cited_text: string,
 *   encrypted_index: string,
 *   title: string|null,
 *   type: 'web_search_result_location',
 *   url: string,
 * }
 */
final class BetaCitationWebSearchResultLocationParam implements BaseModel
{
    /** @use SdkModel<BetaCitationWebSearchResultLocationParamShape> */
    use SdkModel;

    /** @var 'web_search_result_location' $type */
    #[Required]
    public string $type = 'web_search_result_location';

    #[Required]
    public string $cited_text;

    #[Required]
    public string $encrypted_index;

    #[Required]
    public ?string $title;

    #[Required]
    public string $url;

    /**
     * `new BetaCitationWebSearchResultLocationParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaCitationWebSearchResultLocationParam::with(
     *   cited_text: ..., encrypted_index: ..., title: ..., url: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaCitationWebSearchResultLocationParam)
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
        string $cited_text,
        string $encrypted_index,
        ?string $title,
        string $url
    ): self {
        $obj = new self;

        $obj['cited_text'] = $cited_text;
        $obj['encrypted_index'] = $encrypted_index;
        $obj['title'] = $title;
        $obj['url'] = $url;

        return $obj;
    }

    public function withCitedText(string $citedText): self
    {
        $obj = clone $this;
        $obj['cited_text'] = $citedText;

        return $obj;
    }

    public function withEncryptedIndex(string $encryptedIndex): self
    {
        $obj = clone $this;
        $obj['encrypted_index'] = $encryptedIndex;

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
