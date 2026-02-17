<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaWebSearchToolResultBlock\Caller;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type BetaWebSearchToolResultBlockContentVariants from \Anthropic\Beta\Messages\BetaWebSearchToolResultBlockContent
 * @phpstan-import-type CallerVariants from \Anthropic\Beta\Messages\BetaWebSearchToolResultBlock\Caller
 * @phpstan-import-type BetaWebSearchToolResultBlockContentShape from \Anthropic\Beta\Messages\BetaWebSearchToolResultBlockContent
 * @phpstan-import-type CallerShape from \Anthropic\Beta\Messages\BetaWebSearchToolResultBlock\Caller
 *
 * @phpstan-type BetaWebSearchToolResultBlockShape = array{
 *   content: BetaWebSearchToolResultBlockContentShape,
 *   toolUseID: string,
 *   type: 'web_search_tool_result',
 *   caller?: CallerShape|null,
 * }
 */
final class BetaWebSearchToolResultBlock implements BaseModel
{
    /** @use SdkModel<BetaWebSearchToolResultBlockShape> */
    use SdkModel;

    /** @var 'web_search_tool_result' $type */
    #[Required]
    public string $type = 'web_search_tool_result';

    /** @var BetaWebSearchToolResultBlockContentVariants $content */
    #[Required(union: BetaWebSearchToolResultBlockContent::class)]
    public BetaWebSearchToolResultError|array $content;

    #[Required('tool_use_id')]
    public string $toolUseID;

    /**
     * Tool invocation directly from the model.
     *
     * @var CallerVariants|null $caller
     */
    #[Optional(union: Caller::class)]
    public BetaDirectCaller|BetaServerToolCaller|BetaServerToolCaller20260120|null $caller;

    /**
     * `new BetaWebSearchToolResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaWebSearchToolResultBlock::with(content: ..., toolUseID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaWebSearchToolResultBlock)->withContent(...)->withToolUseID(...)
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
     * @param BetaWebSearchToolResultBlockContentShape $content
     * @param CallerShape|null $caller
     */
    public static function with(
        BetaWebSearchToolResultError|array $content,
        string $toolUseID,
        BetaDirectCaller|array|BetaServerToolCaller|BetaServerToolCaller20260120|null $caller = null,
    ): self {
        $self = new self;

        $self['content'] = $content;
        $self['toolUseID'] = $toolUseID;

        null !== $caller && $self['caller'] = $caller;

        return $self;
    }

    /**
     * @param BetaWebSearchToolResultBlockContentShape $content
     */
    public function withContent(
        BetaWebSearchToolResultError|array $content
    ): self {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    public function withToolUseID(string $toolUseID): self
    {
        $self = clone $this;
        $self['toolUseID'] = $toolUseID;

        return $self;
    }

    /**
     * @param 'web_search_tool_result' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Tool invocation directly from the model.
     *
     * @param CallerShape $caller
     */
    public function withCaller(
        BetaDirectCaller|array|BetaServerToolCaller|BetaServerToolCaller20260120 $caller,
    ): self {
        $self = clone $this;
        $self['caller'] = $caller;

        return $self;
    }
}
