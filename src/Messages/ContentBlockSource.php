<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\ContentBlockSource\Content;

/**
 * @phpstan-type content_block_source = array{
 *   content: string|list<TextBlockParam|ImageBlockParam>, type: string
 * }
 */
final class ContentBlockSource implements BaseModel
{
    /** @use SdkModel<content_block_source> */
    use SdkModel;

    #[Api]
    public string $type = 'content';

    /** @var string|list<TextBlockParam|ImageBlockParam> $content */
    #[Api(union: Content::class)]
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
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param string|list<TextBlockParam|ImageBlockParam> $content
     */
    public static function with(string|array $content): self
    {
        $obj = new self;

        $obj->content = $content;

        return $obj;
    }

    /**
     * @param string|list<TextBlockParam|ImageBlockParam> $content
     */
    public function withContent(string|array $content): self
    {
        $obj = clone $this;
        $obj->content = $content;

        return $obj;
    }
}
