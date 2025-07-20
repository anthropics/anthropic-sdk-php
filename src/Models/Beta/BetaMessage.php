<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\Models\Model\UnionMember0;

/**
 * @phpstan-type beta_message_alias = array{
 *   id: string,
 *   container: BetaContainer,
 *   content: list<
 *     BetaTextBlock|BetaThinkingBlock|BetaRedactedThinkingBlock|BetaToolUseBlock|BetaServerToolUseBlock|BetaWebSearchToolResultBlock|BetaCodeExecutionToolResultBlock|BetaMCPToolUseBlock|BetaMCPToolResultBlock|BetaContainerUploadBlock
 *   >,
 *   model: UnionMember0::*|string,
 *   role: string,
 *   stopReason: BetaStopReason::*,
 *   stopSequence: string|null,
 *   type: string,
 *   usage: BetaUsage,
 * }
 */
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
    #[Api(type: new ListOf(union: BetaContentBlock::class))]
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
        self::introspect();

        $this->id = $id;
        $this->container = $container;
        $this->content = $content;
        $this->model = $model;
        $this->stopReason = $stopReason;
        $this->stopSequence = $stopSequence;
        $this->usage = $usage;
    }
}
