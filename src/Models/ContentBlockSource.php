<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\ContentBlockSource\Content;

/**
 * @phpstan-type content_block_source_alias = array{
 *   content: string|list<TextBlockParam|ImageBlockParam>, type: string
 * }
 */
final class ContentBlockSource implements BaseModel
{
    use ModelTrait;

    #[Api]
    public string $type = 'content';

    /** @var list<ImageBlockParam|TextBlockParam>|string $content */
    #[Api(union: Content::class)]
    public array|string $content;

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
     * @param list<ImageBlockParam|TextBlockParam>|string $content
     */
    public static function new(array|string $content): self
    {
        $obj = new self;

        $obj->content = $content;

        return $obj;
    }

    /**
     * @param list<ImageBlockParam|TextBlockParam>|string $content
     */
    public function setContent(array|string $content): self
    {
        $this->content = $content;

        return $this;
    }
}
