<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaContentBlockSource\Content;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_content_block_source_alias = array{
 *   content: string|list<BetaTextBlockParam|BetaImageBlockParam>, type: string
 * }
 */
final class BetaContentBlockSource implements BaseModel
{
    use SdkModel;

    #[Api]
    public string $type = 'content';

    /** @var list<BetaImageBlockParam|BetaTextBlockParam>|string $content */
    #[Api(union: Content::class)]
    public array|string $content;

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
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<BetaImageBlockParam|BetaTextBlockParam>|string $content
     */
    public static function with(array|string $content): self
    {
        $obj = new self;

        $obj->content = $content;

        return $obj;
    }

    /**
     * @param list<BetaImageBlockParam|BetaTextBlockParam>|string $content
     */
    public function withContent(array|string $content): self
    {
        $obj = clone $this;
        $obj->content = $content;

        return $obj;
    }
}
