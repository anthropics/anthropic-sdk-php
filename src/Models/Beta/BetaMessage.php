<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

class BetaMessage implements BaseModel
{
    use Model;

    #[Api]
    public string $id;

    #[Api]
    public BetaContainer $container;

    /**
     * @var list<BetaCodeExecutionToolResultBlock|BetaContainerUploadBlock|BetaMCPToolResultBlock|BetaMCPToolUseBlock|BetaRedactedThinkingBlock|BetaServerToolUseBlock|BetaTextBlock|BetaThinkingBlock|BetaToolUseBlock|BetaWebSearchToolResultBlock> $content
     */
    #[Api(
        type: new ListOf(
            new UnionOf(
                [
                    BetaTextBlock::class,
                    BetaThinkingBlock::class,
                    BetaRedactedThinkingBlock::class,
                    BetaToolUseBlock::class,
                    BetaServerToolUseBlock::class,
                    BetaWebSearchToolResultBlock::class,
                    BetaCodeExecutionToolResultBlock::class,
                    BetaMCPToolUseBlock::class,
                    BetaMCPToolResultBlock::class,
                    BetaContainerUploadBlock::class,
                ],
            ),
        ),
    )]
    public array $content;

    /** @var string|string $model */
    #[Api]
    public mixed $model;

    #[Api]
    public string $role;

    #[Api('stop_reason')]
    public string $stopReason;

    #[Api('stop_sequence')]
    public ?string $stopSequence;

    #[Api]
    public string $type;

    #[Api]
    public BetaUsage $usage;

    /**
     * @param string                                                                                                                                                                                                                                    $id
     * @param BetaContainer                                                                                                                                                                                                                             $container
     * @param list<BetaCodeExecutionToolResultBlock|BetaContainerUploadBlock|BetaMCPToolResultBlock|BetaMCPToolUseBlock|BetaRedactedThinkingBlock|BetaServerToolUseBlock|BetaTextBlock|BetaThinkingBlock|BetaToolUseBlock|BetaWebSearchToolResultBlock> $content
     * @param string|string                                                                                                                                                                                                                             $model
     * @param string                                                                                                                                                                                                                                    $role
     * @param string                                                                                                                                                                                                                                    $stopReason
     * @param null|string                                                                                                                                                                                                                               $stopSequence
     * @param string                                                                                                                                                                                                                                    $type
     * @param BetaUsage                                                                                                                                                                                                                                 $usage
     */
    final public function __construct(
        $id,
        $container,
        $content,
        $model,
        $role,
        $stopReason,
        $stopSequence,
        $type,
        $usage,
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

BetaMessage::_loadMetadata();
