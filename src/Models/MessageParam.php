<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\MessageParam\Content;
use Anthropic\Models\MessageParam\Role;

/**
 * @phpstan-type message_param_alias = array{
 *   content: string|list<TextBlockParam|ImageBlockParam|DocumentBlockParam|SearchResultBlockParam|ThinkingBlockParam|RedactedThinkingBlockParam|ToolUseBlockParam|ToolResultBlockParam|ServerToolUseBlockParam|WebSearchToolResultBlockParam>,
 *   role: Role::*,
 * }
 */
final class MessageParam implements BaseModel
{
    use ModelTrait;

    /**
     * @var list<DocumentBlockParam|ImageBlockParam|RedactedThinkingBlockParam|SearchResultBlockParam|ServerToolUseBlockParam|TextBlockParam|ThinkingBlockParam|ToolResultBlockParam|ToolUseBlockParam|WebSearchToolResultBlockParam>|string $content
     */
    #[Api(union: Content::class)]
    public array|string $content;

    /** @var Role::* $role */
    #[Api(enum: Role::class)]
    public string $role;

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
    public static function new(array|string $content, string $role): self
    {
        $obj = new self;

        $obj->content = $content;
        $obj->role = $role;

        return $obj;
    }

    /**
     * @param list<DocumentBlockParam|ImageBlockParam|RedactedThinkingBlockParam|SearchResultBlockParam|ServerToolUseBlockParam|TextBlockParam|ThinkingBlockParam|ToolResultBlockParam|ToolUseBlockParam|WebSearchToolResultBlockParam>|string $content
     */
    public function setContent(array|string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @param Role::* $role
     */
    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }
}
