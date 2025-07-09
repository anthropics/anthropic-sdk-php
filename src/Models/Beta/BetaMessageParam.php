<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

class BetaMessageParam implements BaseModel
{
    use Model;

    /**
     * @var list<BetaCodeExecutionToolResultBlockParam|BetaContainerUploadBlockParam|BetaImageBlockParam|BetaMCPToolUseBlockParam|BetaRedactedThinkingBlockParam|BetaRequestDocumentBlock|BetaRequestMCPToolResultBlockParam|BetaSearchResultBlockParam|BetaServerToolUseBlockParam|BetaTextBlockParam|BetaThinkingBlockParam|BetaToolResultBlockParam|BetaToolUseBlockParam|BetaWebSearchToolResultBlockParam>|string $content
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
    public mixed $content;

    #[Api]
    public string $role;

    /**
     * @param list<BetaCodeExecutionToolResultBlockParam|BetaContainerUploadBlockParam|BetaImageBlockParam|BetaMCPToolUseBlockParam|BetaRedactedThinkingBlockParam|BetaRequestDocumentBlock|BetaRequestMCPToolResultBlockParam|BetaSearchResultBlockParam|BetaServerToolUseBlockParam|BetaTextBlockParam|BetaThinkingBlockParam|BetaToolResultBlockParam|BetaToolUseBlockParam|BetaWebSearchToolResultBlockParam>|string $content
     * @param string                                                                                                                                                                                                                                                                                                                                                                                                     $role
     */
    final public function __construct($content, $role)
    {
        $this->constructFromArgs(func_get_args());
    }
}

BetaMessageParam::_loadMetadata();
