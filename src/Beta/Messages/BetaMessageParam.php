<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaMessageParam\Content;
use Anthropic\Beta\Messages\BetaMessageParam\Role;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_message_param_alias = array{
 *   content: string|list<BetaTextBlockParam|BetaImageBlockParam|BetaRequestDocumentBlock|BetaSearchResultBlockParam|BetaThinkingBlockParam|BetaRedactedThinkingBlockParam|BetaToolUseBlockParam|BetaToolResultBlockParam|BetaServerToolUseBlockParam|BetaWebSearchToolResultBlockParam|BetaCodeExecutionToolResultBlockParam|BetaMCPToolUseBlockParam|BetaRequestMCPToolResultBlockParam|BetaContainerUploadBlockParam>,
 *   role: Role::*,
 * }
 */
final class BetaMessageParam implements BaseModel
{
    use SdkModel;

    /**
     * @var list<BetaCodeExecutionToolResultBlockParam|BetaContainerUploadBlockParam|BetaImageBlockParam|BetaMCPToolUseBlockParam|BetaRedactedThinkingBlockParam|BetaRequestDocumentBlock|BetaRequestMCPToolResultBlockParam|BetaSearchResultBlockParam|BetaServerToolUseBlockParam|BetaTextBlockParam|BetaThinkingBlockParam|BetaToolResultBlockParam|BetaToolUseBlockParam|BetaWebSearchToolResultBlockParam>|string $content
     */
    #[Api(union: Content::class)]
    public array|string $content;

    /** @var Role::* $role */
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
    public static function with(array|string $content, string $role): self
    {
        $obj = new self;

        $obj->content = $content;
        $obj->role = $role;

        return $obj;
    }

    /**
     * @param list<BetaCodeExecutionToolResultBlockParam|BetaContainerUploadBlockParam|BetaImageBlockParam|BetaMCPToolUseBlockParam|BetaRedactedThinkingBlockParam|BetaRequestDocumentBlock|BetaRequestMCPToolResultBlockParam|BetaSearchResultBlockParam|BetaServerToolUseBlockParam|BetaTextBlockParam|BetaThinkingBlockParam|BetaToolResultBlockParam|BetaToolUseBlockParam|BetaWebSearchToolResultBlockParam>|string $content
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
