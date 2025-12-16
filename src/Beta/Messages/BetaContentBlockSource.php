<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaContentBlockSource\Content;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Messages\BetaContentBlockSource\Content
 *
 * @phpstan-type BetaContentBlockSourceShape = array{
 *   content: ContentShape, type: 'content'
 * }
 */
final class BetaContentBlockSource implements BaseModel
{
    /** @use SdkModel<BetaContentBlockSourceShape> */
    use SdkModel;

    /** @var 'content' $type */
    #[Required]
    public string $type = 'content';

    /** @var string|list<BetaTextBlockParam|BetaImageBlockParam> $content */
    #[Required(union: Content::class)]
    public string|array $content;

    /**
     * `new BetaContentBlockSource()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaContentBlockSource::with(content: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaContentBlockSource)->withContent(...)
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
