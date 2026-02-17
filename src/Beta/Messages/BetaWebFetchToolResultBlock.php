<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaWebFetchToolResultBlock\Caller;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ContentVariants from \Anthropic\Beta\Messages\BetaWebFetchToolResultBlock\Content
 * @phpstan-import-type CallerVariants from \Anthropic\Beta\Messages\BetaWebFetchToolResultBlock\Caller
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Messages\BetaWebFetchToolResultBlock\Content
 * @phpstan-import-type CallerShape from \Anthropic\Beta\Messages\BetaWebFetchToolResultBlock\Caller
 *
 * @phpstan-type BetaWebFetchToolResultBlockShape = array{
 *   content: ContentShape,
 *   toolUseID: string,
 *   type: 'web_fetch_tool_result',
 *   caller?: CallerShape|null,
 * }
 */
final class BetaWebFetchToolResultBlock implements BaseModel
{
    /** @use SdkModel<BetaWebFetchToolResultBlockShape> */
    use SdkModel;

    /** @var 'web_fetch_tool_result' $type */
    #[Required]
    public string $type = 'web_fetch_tool_result';

    /** @var ContentVariants $content */
    #[Required]
    public BetaWebFetchToolResultErrorBlock|BetaWebFetchBlock $content;

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
     * `new BetaWebFetchToolResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaWebFetchToolResultBlock::with(content: ..., toolUseID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaWebFetchToolResultBlock)->withContent(...)->withToolUseID(...)
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
     * @param ContentShape $content
     * @param CallerShape|null $caller
     */
    public static function with(
        BetaWebFetchToolResultErrorBlock|array|BetaWebFetchBlock $content,
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
     * @param ContentShape $content
     */
    public function withContent(
        BetaWebFetchToolResultErrorBlock|array|BetaWebFetchBlock $content
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
     * @param 'web_fetch_tool_result' $type
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
