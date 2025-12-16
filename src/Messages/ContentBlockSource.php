<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\ContentBlockSource\Content;

/**
 * @phpstan-import-type ContentShape from \Anthropic\Messages\ContentBlockSource\Content
 *
 * @phpstan-type ContentBlockSourceShape = array{
 *   content: ContentShape, type: 'content'
 * }
 */
final class ContentBlockSource implements BaseModel
{
    /** @use SdkModel<ContentBlockSourceShape> */
    use SdkModel;

    /** @var 'content' $type */
    #[Required]
    public string $type = 'content';

    /** @var string|list<TextBlockParam|ImageBlockParam> $content */
    #[Required(union: Content::class)]
    public string|array $content;

    /**
     * `new ContentBlockSource()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ContentBlockSource::with(content: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ContentBlockSource)->withContent(...)
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
     * @param ContentShape $content
     */
    public static function with(string|array $content): self
    {
        $self = new self;

        $self['content'] = $content;

        return $self;
    }

    /**
     * @param ContentShape $content
     */
    public function withContent(string|array $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }
}
