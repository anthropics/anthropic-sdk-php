<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\WebFetchToolResultBlock\Caller;

/**
 * @phpstan-import-type CallerVariants from \Anthropic\Messages\WebFetchToolResultBlock\Caller
 * @phpstan-import-type ContentVariants from \Anthropic\Messages\WebFetchToolResultBlock\Content
 * @phpstan-import-type CallerShape from \Anthropic\Messages\WebFetchToolResultBlock\Caller
 * @phpstan-import-type ContentShape from \Anthropic\Messages\WebFetchToolResultBlock\Content
 *
 * @phpstan-type WebFetchToolResultBlockShape = array{
 *   caller: CallerShape,
 *   content: ContentShape,
 *   toolUseID: string,
 *   type: 'web_fetch_tool_result',
 * }
 */
final class WebFetchToolResultBlock implements BaseModel
{
    /** @use SdkModel<WebFetchToolResultBlockShape> */
    use SdkModel;

    /** @var 'web_fetch_tool_result' $type */
    #[Required]
    public string $type = 'web_fetch_tool_result';

    /**
     * Tool invocation directly from the model.
     *
     * @var CallerVariants $caller
     */
    #[Required(union: Caller::class)]
    public DirectCaller|ServerToolCaller|ServerToolCaller20260120 $caller;

    /** @var ContentVariants $content */
    #[Required]
    public WebFetchToolResultErrorBlock|WebFetchBlock $content;

    #[Required('tool_use_id')]
    public string $toolUseID;

    /**
     * `new WebFetchToolResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WebFetchToolResultBlock::with(caller: ..., content: ..., toolUseID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WebFetchToolResultBlock)
     *   ->withCaller(...)
     *   ->withContent(...)
     *   ->withToolUseID(...)
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
     * @param CallerShape $caller
     */
    public static function with(
        WebFetchToolResultErrorBlock|array|WebFetchBlock $content,
        string $toolUseID,
        DirectCaller|array|ServerToolCaller|ServerToolCaller20260120 $caller = [
            'type' => 'direct',
        ],
    ): self {
        $self = new self;

        $self['caller'] = $caller;
        $self['content'] = $content;
        $self['toolUseID'] = $toolUseID;

        return $self;
    }

    /**
     * Tool invocation directly from the model.
     *
     * @param CallerShape $caller
     */
    public function withCaller(
        DirectCaller|array|ServerToolCaller|ServerToolCaller20260120 $caller
    ): self {
        $self = clone $this;
        $self['caller'] = $caller;

        return $self;
    }

    /**
     * @param ContentShape $content
     */
    public function withContent(
        WebFetchToolResultErrorBlock|array|WebFetchBlock $content
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
}
