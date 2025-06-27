<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\None;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

class BetaMessageParam implements BaseModel
{
    use Model;

    /**
     * @var string|list<BetaServerToolUseBlockParam|BetaWebSearchToolResultBlockParam|BetaCodeExecutionToolResultBlockParam|BetaMCPToolUseBlockParam|BetaRequestMCPToolResultBlockParam|BetaTextBlockParam|BetaImageBlockParam|BetaToolUseBlockParam|BetaToolResultBlockParam|BetaRequestDocumentBlock|BetaThinkingBlockParam|BetaRedactedThinkingBlockParam|BetaContainerUploadBlockParam> $content
     */
    #[Api(
        type: new UnionOf(
            [
                'string',
                new ListOf(
                    new UnionOf(
                        [
                            BetaServerToolUseBlockParam::class,
                            BetaWebSearchToolResultBlockParam::class,
                            BetaCodeExecutionToolResultBlockParam::class,
                            BetaMCPToolUseBlockParam::class,
                            BetaRequestMCPToolResultBlockParam::class,
                            BetaTextBlockParam::class,
                            BetaImageBlockParam::class,
                            BetaToolUseBlockParam::class,
                            BetaToolResultBlockParam::class,
                            BetaRequestDocumentBlock::class,
                            BetaThinkingBlockParam::class,
                            BetaRedactedThinkingBlockParam::class,
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
     * @param string|list<BetaServerToolUseBlockParam|BetaWebSearchToolResultBlockParam|BetaCodeExecutionToolResultBlockParam|BetaMCPToolUseBlockParam|BetaRequestMCPToolResultBlockParam|BetaTextBlockParam|BetaImageBlockParam|BetaToolUseBlockParam|BetaToolResultBlockParam|BetaRequestDocumentBlock|BetaThinkingBlockParam|BetaRedactedThinkingBlockParam|BetaContainerUploadBlockParam> $content
     */
    final public function __construct(mixed $content, string $role)
    {

        $args = func_get_args();

        $data = [];
        for ($i = 0; $i < count($args); ++$i) {
            if (None::NOT_SET !== $args[$i]) {
                $data[self::$_constructorArgNames[$i]] = $args[$i] ?? null;
            }
        }

        $this->__unserialize($data);

    }
}

BetaMessageParam::_loadMetadata();
