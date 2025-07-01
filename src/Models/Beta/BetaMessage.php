<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;
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
                    BetaToolUseBlock::class,
                    BetaServerToolUseBlock::class,
                    BetaWebSearchToolResultBlock::class,
                    BetaCodeExecutionToolResultBlock::class,
                    BetaMCPToolUseBlock::class,
                    BetaMCPToolResultBlock::class,
                    BetaContainerUploadBlock::class,
                    BetaThinkingBlock::class,
                    BetaRedactedThinkingBlock::class,
                ],
            ),
        ),
    )]
    public array $content;

    /**
     * @var string|string $model
     */
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
     * @param list<BetaCodeExecutionToolResultBlock|BetaContainerUploadBlock|BetaMCPToolResultBlock|BetaMCPToolUseBlock|BetaRedactedThinkingBlock|BetaServerToolUseBlock|BetaTextBlock|BetaThinkingBlock|BetaToolUseBlock|BetaWebSearchToolResultBlock> $content
     * @param string|string                                                                                                                                                                                                                             $model
     */
    final public function __construct(
        string $id,
        BetaContainer $container,
        array $content,
        mixed $model,
        string $role,
        string $stopReason,
        ?string $stopSequence,
        string $type,
        BetaUsage $usage
    ) {
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

BetaMessage::_loadMetadata();
