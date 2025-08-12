<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaRequestMCPToolResultBlockParam\Content;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_request_mcp_tool_result_block_param_alias = array{
 *   toolUseID: string,
 *   type: string,
 *   cacheControl?: BetaCacheControlEphemeral,
 *   content?: string|list<BetaTextBlockParam>,
 *   isError?: bool,
 * }
 */
final class BetaRequestMCPToolResultBlockParam implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'mcp_tool_result';

    #[Api('tool_use_id')]
    public string $toolUseID;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api('cache_control', optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /** @var null|list<BetaTextBlockParam>|string $content */
    #[Api(union: Content::class, optional: true)]
    public null|array|string $content;

    #[Api('is_error', optional: true)]
    public ?bool $isError;

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
     * @param null|list<BetaTextBlockParam>|string $content
     */
    public static function new(
        string $toolUseID,
        ?BetaCacheControlEphemeral $cacheControl = null,
        null|array|string $content = null,
        ?bool $isError = null,
    ): self {
        $obj = new self;

        $obj->toolUseID = $toolUseID;

        null !== $cacheControl && $obj->cacheControl = $cacheControl;
        null !== $content && $obj->content = $content;
        null !== $isError && $obj->isError = $isError;

        return $obj;
    }

    public function setToolUseID(string $toolUseID): self
    {
        $this->toolUseID = $toolUseID;

        return $this;
    }

    /**
     * Create a cache control breakpoint at this content block.
     */
    public function setCacheControl(
        BetaCacheControlEphemeral $cacheControl
    ): self {
        $this->cacheControl = $cacheControl;

        return $this;
    }

    /**
     * @param list<BetaTextBlockParam>|string $content
     */
    public function setContent(array|string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function setIsError(bool $isError): self
    {
        $this->isError = $isError;

        return $this;
    }
}
