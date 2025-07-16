<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;
use Anthropic\Models\Beta\BetaMessageParam\Role;

final class BetaMessageParam implements BaseModel
{
    use Model;

    /**
     * @var string|list<
     *   BetaTextBlockParam|BetaImageBlockParam|BetaRequestDocumentBlock|BetaSearchResultBlockParam|BetaThinkingBlockParam|BetaRedactedThinkingBlockParam|BetaToolUseBlockParam|BetaToolResultBlockParam|BetaServerToolUseBlockParam|BetaWebSearchToolResultBlockParam|BetaCodeExecutionToolResultBlockParam|BetaMCPToolUseBlockParam|BetaRequestMCPToolResultBlockParam|BetaContainerUploadBlockParam
     * > $content
     */
    #[Api(
        type: new UnionOf(
            [
                'string',
                new ListOf(
                    new UnionOf(
                        [
                            BetaTextBlockParam::class,
                            BetaImageBlockParam::class,
                            BetaRequestDocumentBlock::class,
                            BetaSearchResultBlockParam::class,
                            BetaThinkingBlockParam::class,
                            BetaRedactedThinkingBlockParam::class,
                            BetaToolUseBlockParam::class,
                            BetaToolResultBlockParam::class,
                            BetaServerToolUseBlockParam::class,
                            BetaWebSearchToolResultBlockParam::class,
                            BetaCodeExecutionToolResultBlockParam::class,
                            BetaMCPToolUseBlockParam::class,
                            BetaRequestMCPToolResultBlockParam::class,
                            BetaContainerUploadBlockParam::class,
                        ],
                    ),
                ),
            ],
        ),
    )]
    public array|string $content;

    /** @var Role::* $role */
    #[Api]
    public string $role;

    /**
     * You must use named parameters to construct this object.
     *
     * @param string|list<
     *   BetaTextBlockParam|BetaImageBlockParam|BetaRequestDocumentBlock|BetaSearchResultBlockParam|BetaThinkingBlockParam|BetaRedactedThinkingBlockParam|BetaToolUseBlockParam|BetaToolResultBlockParam|BetaServerToolUseBlockParam|BetaWebSearchToolResultBlockParam|BetaCodeExecutionToolResultBlockParam|BetaMCPToolUseBlockParam|BetaRequestMCPToolResultBlockParam|BetaContainerUploadBlockParam
     * > $content
     * @param Role::* $role
     */
    final public function __construct(array|string $content, string $role)
    {
        $this->content = $content;
        $this->role = $role;
    }
}

BetaMessageParam::_loadMetadata();
