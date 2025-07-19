<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\MessageParam\Content;
use Anthropic\Models\MessageParam\Role;

final class MessageParam implements BaseModel
{
    use Model;

    /**
     * @var string|list<
     *   TextBlockParam|ImageBlockParam|DocumentBlockParam|ThinkingBlockParam|RedactedThinkingBlockParam|ToolUseBlockParam|ToolResultBlockParam|ServerToolUseBlockParam|WebSearchToolResultBlockParam
     * > $content
     */
    #[Api(union: Content::class)]
    public array|string $content;

    /** @var Role::* $role */
    #[Api]
    public string $role;

    /**
     * You must use named parameters to construct this object.
     *
     * @param string|list<
     *   TextBlockParam|ImageBlockParam|DocumentBlockParam|ThinkingBlockParam|RedactedThinkingBlockParam|ToolUseBlockParam|ToolResultBlockParam|ServerToolUseBlockParam|WebSearchToolResultBlockParam
     * > $content
     * @param Role::* $role
     */
    final public function __construct(array|string $content, string $role)
    {
        self::introspect();

        $this->content = $content;
        $this->role = $role;
    }
}
