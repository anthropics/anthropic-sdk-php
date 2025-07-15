<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Concerns\Params;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;
use Anthropic\Models\MessageCountTokensTool\TextEditor20250429;
use Anthropic\Models\MessageParam;
use Anthropic\Models\TextBlockParam;
use Anthropic\Models\ThinkingConfigDisabled;
use Anthropic\Models\ThinkingConfigEnabled;
use Anthropic\Models\Tool;
use Anthropic\Models\ToolBash20250124;
use Anthropic\Models\ToolChoiceAny;
use Anthropic\Models\ToolChoiceAuto;
use Anthropic\Models\ToolChoiceNone;
use Anthropic\Models\ToolChoiceTool;
use Anthropic\Models\ToolTextEditor20250124;
use Anthropic\Models\WebSearchTool20250305;

final class CountTokensParams implements BaseModel
{
    use Model;
    use Params;

    /** @var list<MessageParam> $messages */
    #[Api(type: new ListOf(MessageParam::class))]
    public array $messages;

    #[Api]
    public string $model;

    /** @var null|list<TextBlockParam>|string $system */
    #[Api(
        type: new UnionOf(['string', new ListOf(TextBlockParam::class)]),
        optional: true,
    )]
    public null|array|string $system;

    #[Api(optional: true)]
    public null|ThinkingConfigDisabled|ThinkingConfigEnabled $thinking;

    #[Api('tool_choice', optional: true)]
    public null|ToolChoiceAny|ToolChoiceAuto|ToolChoiceNone|ToolChoiceTool $toolChoice;

    /**
     * @var list<
     *   Tool|ToolBash20250124|ToolTextEditor20250124|TextEditor20250429|WebSearchTool20250305
     * >|null $tools
     */
    #[Api(
        type: new ListOf(
            new UnionOf(
                [
                    Tool::class,
                    ToolBash20250124::class,
                    ToolTextEditor20250124::class,
                    TextEditor20250429::class,
                    WebSearchTool20250305::class,
                ],
            ),
        ),
        optional: true,
    )]
    public ?array $tools;

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param list<MessageParam>                                         $messages   `required`
     * @param string                                                     $model      `required`
     * @param null|list<TextBlockParam>|string                           $system
     * @param ThinkingConfigDisabled|ThinkingConfigEnabled               $thinking
     * @param ToolChoiceAny|ToolChoiceAuto|ToolChoiceNone|ToolChoiceTool $toolChoice
     * @param list<
     *   Tool|ToolBash20250124|ToolTextEditor20250124|TextEditor20250429|WebSearchTool20250305
     * >|null $tools
     */
    final public function __construct(
        $messages,
        $model,
        $system = None::NOT_GIVEN,
        $thinking = None::NOT_GIVEN,
        $toolChoice = None::NOT_GIVEN,
        $tools = None::NOT_GIVEN,
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

CountTokensParams::_loadMetadata();
