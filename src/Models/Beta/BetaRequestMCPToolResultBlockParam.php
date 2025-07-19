<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaRequestMCPToolResultBlockParam\Content;

final class BetaRequestMCPToolResultBlockParam implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'mcp_tool_result';

    #[Api('tool_use_id')]
    public string $toolUseID;

    #[Api('cache_control', optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /** @var null|list<BetaTextBlockParam>|string $content */
    #[Api(union: Content::class, optional: true)]
    public null|array|string $content;

    #[Api('is_error', optional: true)]
    public ?bool $isError;

    /**
     * You must use named parameters to construct this object.
     *
     * @param null|list<BetaTextBlockParam>|string $content
     */
    final public function __construct(
        string $toolUseID,
        ?BetaCacheControlEphemeral $cacheControl = null,
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
