<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaContentBlockSource\Content;

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

    /**
     * You must use named parameters to construct this object.
     *
     * @param list<BetaImageBlockParam|BetaTextBlockParam>|string $content
     */
    final public function __construct(array|string $content)
    {
        self::introspect();

        $this->content = $content;
    }
}
