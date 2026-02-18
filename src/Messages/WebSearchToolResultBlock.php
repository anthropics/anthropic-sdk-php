<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\WebSearchToolResultBlock\Caller;

/**
 * @phpstan-import-type CallerVariants from \Anthropic\Messages\WebSearchToolResultBlock\Caller
 * @phpstan-import-type WebSearchToolResultBlockContentVariants from \Anthropic\Messages\WebSearchToolResultBlockContent
 * @phpstan-import-type CallerShape from \Anthropic\Messages\WebSearchToolResultBlock\Caller
 * @phpstan-import-type WebSearchToolResultBlockContentShape from \Anthropic\Messages\WebSearchToolResultBlockContent
 *
 * @phpstan-type WebSearchToolResultBlockShape = array{
 *   caller: CallerShape,
 *   content: WebSearchToolResultBlockContentShape,
 *   toolUseID: string,
 *   type: 'web_search_tool_result',
 * }
 */
final class WebSearchToolResultBlock implements BaseModel
{
    /** @use SdkModel<WebSearchToolResultBlockShape> */
    use SdkModel;

    /** @var 'web_search_tool_result' $type */
    #[Required]
    public string $type = 'web_search_tool_result';

    /**
     * Tool invocation directly from the model.
     *
     * @var CallerVariants $caller
     */
    #[Required(union: Caller::class)]
    public DirectCaller|ServerToolCaller|ServerToolCaller20260120 $caller;

    /** @var WebSearchToolResultBlockContentVariants $content */
    #[Required(union: WebSearchToolResultBlockContent::class)]
    public WebSearchToolResultError|array $content;

    #[Required('tool_use_id')]
    public string $toolUseID;

    /**
     * `new WebSearchToolResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WebSearchToolResultBlock::with(caller: ..., content: ..., toolUseID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WebSearchToolResultBlock)
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
     * @param WebSearchToolResultBlockContentShape $content
     * @param CallerShape $caller
     */
    public static function with(
        WebSearchToolResultError|array $content,
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
     * @param WebSearchToolResultBlockContentShape $content
     */
    public function withContent(WebSearchToolResultError|array $content): self
    {
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
}
