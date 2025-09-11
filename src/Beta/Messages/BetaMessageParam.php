<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaMessageParam\Content;
use Anthropic\Beta\Messages\BetaMessageParam\Role;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_message_param = array{
 *   content: string|list<BetaTextBlockParam|BetaImageBlockParam|BetaRequestDocumentBlock|BetaSearchResultBlockParam|BetaThinkingBlockParam|BetaRedactedThinkingBlockParam|BetaToolUseBlockParam|BetaToolResultBlockParam|BetaServerToolUseBlockParam|BetaWebSearchToolResultBlockParam|BetaWebFetchToolResultBlockParam|BetaCodeExecutionToolResultBlockParam|BetaBashCodeExecutionToolResultBlockParam|BetaTextEditorCodeExecutionToolResultBlockParam|BetaMCPToolUseBlockParam|BetaRequestMCPToolResultBlockParam|BetaContainerUploadBlockParam>,
 *   role: value-of<Role>,
 * }
 */
final class BetaMessageParam implements BaseModel
{
    /** @use SdkModel<beta_message_param> */
    use SdkModel;

    /**
     * @var string|list<BetaTextBlockParam|BetaImageBlockParam|BetaRequestDocumentBlock|BetaSearchResultBlockParam|BetaThinkingBlockParam|BetaRedactedThinkingBlockParam|BetaToolUseBlockParam|BetaToolResultBlockParam|BetaServerToolUseBlockParam|BetaWebSearchToolResultBlockParam|BetaWebFetchToolResultBlockParam|BetaCodeExecutionToolResultBlockParam|BetaBashCodeExecutionToolResultBlockParam|BetaTextEditorCodeExecutionToolResultBlockParam|BetaMCPToolUseBlockParam|BetaRequestMCPToolResultBlockParam|BetaContainerUploadBlockParam> $content
     */
    #[Api(union: Content::class)]
    public string|array $content;

    /** @var value-of<Role> $role */
    #[Api(enum: Role::class)]
    public string $role;

    /**
     * `new BetaMessageParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaMessageParam::with(content: ..., role: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaMessageParam)->withContent(...)->withRole(...)
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
     * @param string|list<BetaTextBlockParam|BetaImageBlockParam|BetaRequestDocumentBlock|BetaSearchResultBlockParam|BetaThinkingBlockParam|BetaRedactedThinkingBlockParam|BetaToolUseBlockParam|BetaToolResultBlockParam|BetaServerToolUseBlockParam|BetaWebSearchToolResultBlockParam|BetaWebFetchToolResultBlockParam|BetaCodeExecutionToolResultBlockParam|BetaBashCodeExecutionToolResultBlockParam|BetaTextEditorCodeExecutionToolResultBlockParam|BetaMCPToolUseBlockParam|BetaRequestMCPToolResultBlockParam|BetaContainerUploadBlockParam> $content
     * @param Role|value-of<Role> $role
     */
    public static function with(string|array $content, Role|string $role): self
    {
        $obj = new self;

        $obj->content = $content;
        $obj->role = $role instanceof Role ? $role->value : $role;

        return $obj;
    }

    /**
     * @param string|list<BetaTextBlockParam|BetaImageBlockParam|BetaRequestDocumentBlock|BetaSearchResultBlockParam|BetaThinkingBlockParam|BetaRedactedThinkingBlockParam|BetaToolUseBlockParam|BetaToolResultBlockParam|BetaServerToolUseBlockParam|BetaWebSearchToolResultBlockParam|BetaWebFetchToolResultBlockParam|BetaCodeExecutionToolResultBlockParam|BetaBashCodeExecutionToolResultBlockParam|BetaTextEditorCodeExecutionToolResultBlockParam|BetaMCPToolUseBlockParam|BetaRequestMCPToolResultBlockParam|BetaContainerUploadBlockParam> $content
     */
    public function withContent(string|array $content): self
    {
        $obj = clone $this;
        $obj->content = $content;

        return $obj;
    }

    /**
     * @param Role|value-of<Role> $role
     */
    public function withRole(Role|string $role): self
    {
        $obj = clone $this;
        $obj->role = $role instanceof Role ? $role->value : $role;

        return $obj;
    }
}
