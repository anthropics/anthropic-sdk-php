<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

final class ToolResultBlockParam implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'tool_result';

    #[Api('tool_use_id')]
    public string $toolUseID;

    #[Api('cache_control', optional: true)]
    public ?CacheControlEphemeral $cacheControl;

    /** @var null|list<ImageBlockParam|TextBlockParam>|string $content */
    #[Api(
        union: new UnionOf(
            [
                'string',
                new ListOf(
                    union: new UnionOf([TextBlockParam::class, ImageBlockParam::class])
                ),
            ],
        ),
        optional: true,
    )]
    public null|array|string $content;

    #[Api('is_error', optional: true)]
    public ?bool $isError;

    /**
     * You must use named parameters to construct this object.
     *
     * @param null|list<ImageBlockParam|TextBlockParam>|string $content
     */
    final public function __construct(
        string $toolUseID,
        ?CacheControlEphemeral $cacheControl = null,
        null|array|string $content = null,
        ?bool $isError = null,
    ) {
        self::introspect();
        $this->unsetOptionalProperties();

        $this->toolUseID = $toolUseID;

        null !== $cacheControl && $this->cacheControl = $cacheControl;
        null !== $content && $this->content = $content;
        null !== $isError && $this->isError = $isError;
    }
}
