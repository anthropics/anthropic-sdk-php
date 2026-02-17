<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type DocumentBlockShape from \Anthropic\Messages\DocumentBlock
 *
 * @phpstan-type WebFetchBlockShape = array{
 *   content: DocumentBlock|DocumentBlockShape,
 *   retrievedAt: string|null,
 *   type: 'web_fetch_result',
 *   url: string,
 * }
 */
final class WebFetchBlock implements BaseModel
{
    /** @use SdkModel<WebFetchBlockShape> */
    use SdkModel;

    /** @var 'web_fetch_result' $type */
    #[Required]
    public string $type = 'web_fetch_result';

    #[Required]
    public DocumentBlock $content;

    /**
     * ISO 8601 timestamp when the content was retrieved.
     */
    #[Required('retrieved_at')]
    public ?string $retrievedAt;

    /**
     * Fetched content URL.
     */
    #[Required]
    public string $url;

    /**
     * `new WebFetchBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WebFetchBlock::with(content: ..., retrievedAt: ..., url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WebFetchBlock)->withContent(...)->withRetrievedAt(...)->withURL(...)
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
     *
     * @param DocumentBlock|DocumentBlockShape $content
     */
    public static function with(
        DocumentBlock|array $content,
        ?string $retrievedAt,
        string $url
    ): self {
        $self = new self;

        $self['content'] = $content;
        $self['retrievedAt'] = $retrievedAt;
        $self['url'] = $url;

        return $self;
    }

    /**
     * @param DocumentBlock|DocumentBlockShape $content
     */
    public function withContent(DocumentBlock|array $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    /**
     * ISO 8601 timestamp when the content was retrieved.
     */
    public function withRetrievedAt(?string $retrievedAt): self
    {
        $self = clone $this;
        $self['retrievedAt'] = $retrievedAt;

        return $self;
    }

    /**
     * @param 'web_fetch_result' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Fetched content URL.
     */
    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
