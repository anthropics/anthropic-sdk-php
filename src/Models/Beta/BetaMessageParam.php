<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaMessageParam\Content;
use Anthropic\Models\Beta\BetaMessageParam\Role;

/**
 * @phpstan-type beta_message_param_alias = array{
 *   content: string|list<BetaTextBlockParam|BetaImageBlockParam|BetaRequestDocumentBlock|BetaSearchResultBlockParam|BetaThinkingBlockParam|BetaRedactedThinkingBlockParam|BetaToolUseBlockParam|BetaToolResultBlockParam|BetaServerToolUseBlockParam|BetaWebSearchToolResultBlockParam|BetaCodeExecutionToolResultBlockParam|BetaMCPToolUseBlockParam|BetaRequestMCPToolResultBlockParam|BetaContainerUploadBlockParam>,
 *   role: Role::*,
 * }
 */
final class BetaMessageParam implements BaseModel
{
    use Model;

    /**
     * @var list<BetaCodeExecutionToolResultBlockParam|BetaContainerUploadBlockParam|BetaImageBlockParam|BetaMCPToolUseBlockParam|BetaRedactedThinkingBlockParam|BetaRequestDocumentBlock|BetaRequestMCPToolResultBlockParam|BetaSearchResultBlockParam|BetaServerToolUseBlockParam|BetaTextBlockParam|BetaThinkingBlockParam|BetaToolResultBlockParam|BetaToolUseBlockParam|BetaWebSearchToolResultBlockParam>|string $content
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
     * @param list<BetaCodeExecutionToolResultBlockParam|BetaContainerUploadBlockParam|BetaImageBlockParam|BetaMCPToolUseBlockParam|BetaRedactedThinkingBlockParam|BetaRequestDocumentBlock|BetaRequestMCPToolResultBlockParam|BetaSearchResultBlockParam|BetaServerToolUseBlockParam|BetaTextBlockParam|BetaThinkingBlockParam|BetaToolResultBlockParam|BetaToolUseBlockParam|BetaWebSearchToolResultBlockParam>|string $content
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
     * @param list<BetaCodeExecutionToolResultBlockParam|BetaContainerUploadBlockParam|BetaImageBlockParam|BetaMCPToolUseBlockParam|BetaRedactedThinkingBlockParam|BetaRequestDocumentBlock|BetaRequestMCPToolResultBlockParam|BetaSearchResultBlockParam|BetaServerToolUseBlockParam|BetaTextBlockParam|BetaThinkingBlockParam|BetaToolResultBlockParam|BetaToolUseBlockParam|BetaWebSearchToolResultBlockParam>|string $content
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
