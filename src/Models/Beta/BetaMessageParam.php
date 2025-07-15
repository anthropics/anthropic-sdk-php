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
    public mixed $content;

    #[Api]
    public string $role;

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param string|list<
     *   BetaTextBlockParam|BetaImageBlockParam|BetaRequestDocumentBlock|BetaSearchResultBlockParam|BetaThinkingBlockParam|BetaRedactedThinkingBlockParam|BetaToolUseBlockParam|BetaToolResultBlockParam|BetaServerToolUseBlockParam|BetaWebSearchToolResultBlockParam|BetaCodeExecutionToolResultBlockParam|BetaMCPToolUseBlockParam|BetaRequestMCPToolResultBlockParam|BetaContainerUploadBlockParam
     * > $content `required`
     * @param string $role `required`
     */
    final public function __construct($content, $role)
    {
        $this->constructFromArgs(func_get_args());
    }
}

BetaMessageParam::_loadMetadata();
