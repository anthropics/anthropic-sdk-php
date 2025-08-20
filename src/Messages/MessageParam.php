<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\MessageParam\Content;
use Anthropic\Messages\MessageParam\Role;

/**
 * @phpstan-type message_param_alias = array{
 *   content: string|list<TextBlockParam|ImageBlockParam|DocumentBlockParam|SearchResultBlockParam|ThinkingBlockParam|RedactedThinkingBlockParam|ToolUseBlockParam|ToolResultBlockParam|ServerToolUseBlockParam|WebSearchToolResultBlockParam>,
 *   role: Role::*,
 * }
 */
final class MessageParam implements BaseModel
{
    use SdkModel;

    /**
     * @var string|list<TextBlockParam|ImageBlockParam|DocumentBlockParam|SearchResultBlockParam|ThinkingBlockParam|RedactedThinkingBlockParam|ToolUseBlockParam|ToolResultBlockParam|ServerToolUseBlockParam|WebSearchToolResultBlockParam> $content
     */
    #[Api(union: Content::class)]
    public string|array $content;

    /** @var Role::* $role */
    #[Api(enum: Role::class)]
    public string $role;

    /**
     * `new MessageParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MessageParam::with(content: ..., role: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MessageParam)->withContent(...)->withRole(...)
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
     * @param string|list<TextBlockParam|ImageBlockParam|DocumentBlockParam|SearchResultBlockParam|ThinkingBlockParam|RedactedThinkingBlockParam|ToolUseBlockParam|ToolResultBlockParam|ServerToolUseBlockParam|WebSearchToolResultBlockParam> $content
     * @param Role::* $role
     */
    public static function with(string|array $content, string $role): self
    {
        $obj = new self;

        $obj->content = $content;
        $obj->role = $role;

        return $obj;
    }

    /**
     * @param string|list<TextBlockParam|ImageBlockParam|DocumentBlockParam|SearchResultBlockParam|ThinkingBlockParam|RedactedThinkingBlockParam|ToolUseBlockParam|ToolResultBlockParam|ServerToolUseBlockParam|WebSearchToolResultBlockParam> $content
     */
    public function withContent(string|array $content): self
    {
        $obj = clone $this;
        $obj->content = $content;

        return $obj;
    }

    /**
     * @param Role::* $role
     */
    public function withRole(string $role): self
    {
        $obj = clone $this;
        $obj->role = $role;

        return $obj;
    }
}
