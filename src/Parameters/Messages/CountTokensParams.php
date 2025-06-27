<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Concerns\Params;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;
use Anthropic\Models\ThinkingConfigEnabled;
use Anthropic\Models\ThinkingConfigDisabled;
use Anthropic\Models\ToolChoiceAuto;
use Anthropic\Models\ToolChoiceAny;
use Anthropic\Models\ToolChoiceTool;
use Anthropic\Models\ToolChoiceNone;
use Anthropic\Models\CacheControlEphemeral;
use Anthropic\Models\MessageParam;
use Anthropic\Models\TextBlockParam;
use Anthropic\Models\Tool;
use Anthropic\Models\ToolBash20250124;
use Anthropic\Models\ToolTextEditor20250124;
use Anthropic\Models\WebSearchTool20250305;

class CountTokensParams implements BaseModel
{
    use Model;
    use Params;

    /**
     * @var list<MessageParam> $messages
     */
    #[Api(type: new ListOf(MessageParam::class))]
    public array $messages;

    /**
     * @var string|string $model
     */
    #[Api]
    public mixed $model;

    /**
     * @var string|list<TextBlockParam> $system
     */
    #[Api(
        type: new UnionOf(['string', new ListOf(TextBlockParam::class)]),
        optional: true,
    )]
    public mixed $system;

    /**
     * @var ThinkingConfigEnabled|ThinkingConfigDisabled $thinking
     */
    #[Api(optional: true)]
    public mixed $thinking;

    /**
     * @var ToolChoiceAuto|ToolChoiceAny|ToolChoiceTool|ToolChoiceNone $toolChoice
     */
    #[Api('tool_choice', optional: true)]
    public mixed $toolChoice;

    /**
     * @var list<Tool|ToolBash20250124|ToolTextEditor20250124|array{
     *
     * name?: string, type?: string, cacheControl?: CacheControlEphemeral
     *
     * }|WebSearchTool20250305> $tools
     */
    #[Api(
        type: new ListOf(
            new UnionOf(
                [
                    Tool::class,
                    ToolBash20250124::class,
                    ToolTextEditor20250124::class,
                    new ListOf('mixed'),
                    WebSearchTool20250305::class,
                ],
            ),
        ),
        optional: true,
    )]
    public array $tools;
}

CountTokensParams::_loadMetadata();
