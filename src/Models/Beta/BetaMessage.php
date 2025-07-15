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
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param string        $id        `required`
     * @param BetaContainer $container `required`
     * @param list<
     *   BetaTextBlock|BetaThinkingBlock|BetaRedactedThinkingBlock|BetaToolUseBlock|BetaServerToolUseBlock|BetaWebSearchToolResultBlock|BetaCodeExecutionToolResultBlock|BetaMCPToolUseBlock|BetaMCPToolResultBlock|BetaContainerUploadBlock
     * > $content `required`
     * @param string|string $model        `required`
     * @param string        $role         `required`
     * @param string        $stopReason   `required`
     * @param null|string   $stopSequence `required`
     * @param string        $type         `required`
     * @param BetaUsage     $usage        `required`
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
