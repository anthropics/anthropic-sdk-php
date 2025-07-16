<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;
use Anthropic\Models\Model\UnionMember0;

final class BetaMessage implements BaseModel
{
    use Model;

    #[Api]
    public string $role = 'assistant';

    #[Api]
    public string $type = 'message';

    #[Api]
    public string $id;

    #[Api]
    public BetaContainer $container;

    /**
     * @var list<
     *   BetaTextBlock|BetaThinkingBlock|BetaRedactedThinkingBlock|BetaToolUseBlock|BetaServerToolUseBlock|BetaWebSearchToolResultBlock|BetaCodeExecutionToolResultBlock|BetaMCPToolUseBlock|BetaMCPToolResultBlock|BetaContainerUploadBlock
     * > $content
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

    /** @var string|UnionMember0::* $model */
    #[Api]
    public string $model;

    /** @var BetaStopReason::* $stopReason */
    #[Api('stop_reason')]
    public string $stopReason;

    #[Api('stop_sequence')]
    public ?string $stopSequence;

    #[Api]
    public BetaUsage $usage;

    /**
     * You must use named parameters to construct this object.
     *
     * @param list<
     *   BetaTextBlock|BetaThinkingBlock|BetaRedactedThinkingBlock|BetaToolUseBlock|BetaServerToolUseBlock|BetaWebSearchToolResultBlock|BetaCodeExecutionToolResultBlock|BetaMCPToolUseBlock|BetaMCPToolResultBlock|BetaContainerUploadBlock
     * > $content
     * @param string|UnionMember0::* $model
     * @param BetaStopReason::*      $stopReason
     */
    final public function __construct(
        string $id,
        BetaContainer $container,
        array $content,
        string $model,
        string $stopReason,
        ?string $stopSequence,
        BetaUsage $usage,
    ) {
        $this->id = $id;
        $this->container = $container;
        $this->content = $content;
        $this->model = $model;
        $this->stopReason = $stopReason;
        $this->stopSequence = $stopSequence;
        $this->usage = $usage;
    }
}

BetaMessage::__introspect();
