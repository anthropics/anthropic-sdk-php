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
use Anthropic\Models\MessageParam;
use Anthropic\Models\Metadata;
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
use Anthropic\Models\ToolUnion\TextEditor20250429;
use Anthropic\Models\WebSearchTool20250305;

final class CreateParams implements BaseModel
{
    use Model;
    use Params;

    #[Api('max_tokens')]
    public int $maxTokens;

    /** @var list<MessageParam> $messages */
    #[Api(type: new ListOf(MessageParam::class))]
    public array $messages;

    /** @var string|string $model */
    #[Api]
    public mixed $model;

    #[Api(optional: true)]
    public ?Metadata $metadata;

    #[Api('service_tier', optional: true)]
    public ?string $serviceTier;

    /** @var null|list<string> $stopSequences */
    #[Api('stop_sequences', type: new ListOf('string'), optional: true)]
    public ?array $stopSequences;

    #[Api(optional: true)]
    public ?bool $stream;

    /** @var null|list<TextBlockParam>|string $system */
    #[Api(
        type: new UnionOf(['string', new ListOf(TextBlockParam::class)]),
        optional: true,
    )]
    public mixed $system;

    #[Api(optional: true)]
    public ?float $temperature;

    /** @var null|ThinkingConfigDisabled|ThinkingConfigEnabled $thinking */
    #[Api(optional: true)]
    public mixed $thinking;

    /**
     * @var null|ToolChoiceAny|ToolChoiceAuto|ToolChoiceNone|ToolChoiceTool $toolChoice
     */
    #[Api('tool_choice', optional: true)]
    public mixed $toolChoice;

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

    #[Api('top_k', optional: true)]
    public ?int $topK;

    #[Api('top_p', optional: true)]
    public ?float $topP;

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param int                                                        $maxTokens     `required`
     * @param list<MessageParam>                                         $messages      `required`
     * @param string|string                                              $model         `required`
     * @param Metadata                                                   $metadata
     * @param null|string                                                $serviceTier
     * @param null|list<string>                                          $stopSequences
     * @param null|bool                                                  $stream        `required`
     * @param null|list<TextBlockParam>|string                           $system
     * @param null|float                                                 $temperature
     * @param ThinkingConfigDisabled|ThinkingConfigEnabled               $thinking
     * @param ToolChoiceAny|ToolChoiceAuto|ToolChoiceNone|ToolChoiceTool $toolChoice
     * @param list<
     *   Tool|ToolBash20250124|ToolTextEditor20250124|TextEditor20250429|WebSearchTool20250305
     * >|null $tools
     * @param null|int   $topK
     * @param null|float $topP
     */
    final public function __construct(
        $maxTokens,
        $messages,
        $model,
        $stream,
        $metadata = None::NOT_GIVEN,
        $serviceTier = None::NOT_GIVEN,
        $stopSequences = None::NOT_GIVEN,
        $system = None::NOT_GIVEN,
        $temperature = None::NOT_GIVEN,
        $thinking = None::NOT_GIVEN,
        $toolChoice = None::NOT_GIVEN,
        $tools = None::NOT_GIVEN,
        $topK = None::NOT_GIVEN,
        $topP = None::NOT_GIVEN,
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

CreateParams::_loadMetadata();
