<?php

declare(strict_types=1);

namespace Anthropic\Parameters;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Concerns\Params;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\Core\Conversion\UnionOf;
use Anthropic\Models\MessageCountTokensTool\TextEditor20250429;
use Anthropic\Models\MessageParam;
use Anthropic\Models\Model\UnionMember0;
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

final class MessageCountTokensParam implements BaseModel
{
    use Model;
    use Params;

    /** @var list<MessageParam> $messages */
    #[Api(type: new ListOf(MessageParam::class))]
    public array $messages;

    /** @var string|UnionMember0::* $model */
    #[Api]
    public string $model;

    /** @var null|list<TextBlockParam>|string $system */
    #[Api(
        union: new UnionOf(['string', new ListOf(TextBlockParam::class)]),
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
            union: new UnionOf(
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
     * You must use named parameters to construct this object.
     *
     * @param list<MessageParam>               $messages
     * @param string|UnionMember0::*           $model
     * @param null|list<TextBlockParam>|string $system
     * @param list<
     *   Tool|ToolBash20250124|ToolTextEditor20250124|TextEditor20250429|WebSearchTool20250305
     * >|null $tools
     */
    final public function __construct(
        array $messages,
        string $model,
        null|array|string $system = null,
        null|ThinkingConfigDisabled|ThinkingConfigEnabled $thinking = null,
        null|ToolChoiceAny|ToolChoiceAuto|ToolChoiceNone|ToolChoiceTool $toolChoice = null,
        ?array $tools = null,
    ) {
        self::introspect();
        $this->unsetOptionalProperties();

        $this->messages = $messages;
        $this->model = $model;

        null !== $system && $this->system = $system;
        null !== $thinking && $this->thinking = $thinking;
        null !== $toolChoice && $this->toolChoice = $toolChoice;
        null !== $tools && $this->tools = $tools;
    }
}
