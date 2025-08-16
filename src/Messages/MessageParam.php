<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
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
    use Model;

    /**
     * @var list<DocumentBlockParam|ImageBlockParam|RedactedThinkingBlockParam|SearchResultBlockParam|ServerToolUseBlockParam|TextBlockParam|ThinkingBlockParam|ToolResultBlockParam|ToolUseBlockParam|WebSearchToolResultBlockParam>|string $content
     */
    #[Api(union: Content::class)]
    public array|string $content;

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
     * @param list<DocumentBlockParam|ImageBlockParam|RedactedThinkingBlockParam|SearchResultBlockParam|ServerToolUseBlockParam|TextBlockParam|ThinkingBlockParam|ToolResultBlockParam|ToolUseBlockParam|WebSearchToolResultBlockParam>|string $content
     * @param Role::* $role
     */
    public static function with(array|string $content, string $role): self
    {
        $obj = new self;

        $obj->content = $content;
        $obj->role = $role;

        return $obj;
    }

    /**
     * @param list<DocumentBlockParam|ImageBlockParam|RedactedThinkingBlockParam|SearchResultBlockParam|ServerToolUseBlockParam|TextBlockParam|ThinkingBlockParam|ToolResultBlockParam|ToolUseBlockParam|WebSearchToolResultBlockParam>|string $content
     */
    public function withContent(array|string $content): self
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
