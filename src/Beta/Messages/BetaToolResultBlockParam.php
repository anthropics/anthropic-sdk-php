<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaToolResultBlockParam\Content;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_tool_result_block_param_alias = array{
 *   toolUseID: string,
 *   type: string,
 *   cacheControl?: BetaCacheControlEphemeral,
 *   content?: string|list<BetaTextBlockParam|BetaImageBlockParam|BetaSearchResultBlockParam>,
 *   isError?: bool,
 * }
 */
final class BetaToolResultBlockParam implements BaseModel
{
    use SdkModel;

    #[Api]
    public string $type = 'tool_result';

    #[Api('tool_use_id')]
    public string $toolUseID;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api('cache_control', optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * @var string|list<BetaTextBlockParam|BetaImageBlockParam|BetaSearchResultBlockParam>|null $content
     */
    #[Api(union: Content::class, optional: true)]
    public string|array|null $content;

    #[Api('is_error', optional: true)]
    public ?bool $isError;

    /**
     * `new BetaToolResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaToolResultBlockParam::with(toolUseID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaToolResultBlockParam)->withToolUseID(...)
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
     * @param string|list<BetaTextBlockParam|BetaImageBlockParam|BetaSearchResultBlockParam>|null $content
     */
    public static function with(
        string $toolUseID,
        ?BetaCacheControlEphemeral $cacheControl = null,
        string|array|null $content = null,
        ?bool $isError = null,
    ): self {
        $obj = new self;

        $obj->toolUseID = $toolUseID;

        null !== $cacheControl && $obj->cacheControl = $cacheControl;
        null !== $content && $obj->content = $content;
        null !== $isError && $obj->isError = $isError;

        return $obj;
    }

    public function withToolUseID(string $toolUseID): self
    {
        $obj = clone $this;
        $obj->toolUseID = $toolUseID;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     */
    public function withCacheControl(
        BetaCacheControlEphemeral $cacheControl
    ): self {
        $obj = clone $this;
        $obj->cacheControl = $cacheControl;

        return $obj;
    }

    /**
     * @param string|list<BetaTextBlockParam|BetaImageBlockParam|BetaSearchResultBlockParam> $content
     */
    public function withContent(string|array $content): self
    {
        $obj = clone $this;
        $obj->content = $content;

        return $obj;
    }

    public function withIsError(bool $isError): self
    {
        $obj = clone $this;
        $obj->isError = $isError;

        return $obj;
    }
}
