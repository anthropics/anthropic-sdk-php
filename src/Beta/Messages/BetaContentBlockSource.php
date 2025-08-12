<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaContentBlockSource\Content;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_content_block_source_alias = array{
 *   content: string|list<BetaTextBlockParam|BetaImageBlockParam>, type: string
 * }
 */
final class BetaContentBlockSource implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'content';

    /** @var list<BetaImageBlockParam|BetaTextBlockParam>|string $content */
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
     * @param list<BetaImageBlockParam|BetaTextBlockParam>|string $content
     */
    public static function from(array|string $content): self
    {
        $obj = new self;

        $obj->content = $content;

        return $obj;
    }

    /**
     * @param list<BetaImageBlockParam|BetaTextBlockParam>|string $content
     */
    public function setContent(array|string $content): self
    {
        $this->content = $content;

        return $this;
    }
}
