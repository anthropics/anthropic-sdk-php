<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type DocumentBlockParamShape from \Anthropic\Messages\DocumentBlockParam
 *
 * @phpstan-type WebFetchBlockParamShape = array{
 *   content: DocumentBlockParam|DocumentBlockParamShape,
 *   type: 'web_fetch_result',
 *   url: string,
 *   retrievedAt?: string|null,
 * }
 */
final class WebFetchBlockParam implements BaseModel
{
    /** @use SdkModel<WebFetchBlockParamShape> */
    use SdkModel;

    /** @var 'web_fetch_result' $type */
    #[Required]
    public string $type = 'web_fetch_result';

    #[Required]
    public DocumentBlockParam $content;

    /**
     * Fetched content URL.
     */
    #[Required]
    public string $url;

    /**
     * ISO 8601 timestamp when the content was retrieved.
     */
    #[Optional('retrieved_at', nullable: true)]
    public ?string $retrievedAt;

    /**
     * `new WebFetchBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WebFetchBlockParam::with(content: ..., url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WebFetchBlockParam)->withContent(...)->withURL(...)
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
     * @param DocumentBlockParam|DocumentBlockParamShape $content
     */
    public static function with(
        DocumentBlockParam|array $content,
        string $url,
        ?string $retrievedAt = null
    ): self {
        $self = new self;

        $self['content'] = $content;
        $self['url'] = $url;

        null !== $retrievedAt && $self['retrievedAt'] = $retrievedAt;

        return $self;
    }

    /**
     * @param DocumentBlockParam|DocumentBlockParamShape $content
     */
    public function withContent(DocumentBlockParam|array $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

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

    /**
     * ISO 8601 timestamp when the content was retrieved.
     */
    public function withRetrievedAt(?string $retrievedAt): self
    {
        $self = clone $this;
        $self['retrievedAt'] = $retrievedAt;

        return $self;
    }
}
