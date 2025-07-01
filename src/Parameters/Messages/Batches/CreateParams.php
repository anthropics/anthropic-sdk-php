<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Messages\Batches;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Concerns\Params;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Models\CacheControlEphemeral;
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
use Anthropic\Models\WebSearchTool20250305;

class CreateParams implements BaseModel
{
    use Model;
    use Params;

    /**
     * @var list<array{
     *
     *     customID?: string,
     *     params?: array{
     *
     *         maxTokens?: int,
     *         messages?: list<MessageParam>,
     *         model?: string|string,
     *         metadata?: Metadata,
     *         serviceTier?: string,
     *         stopSequences?: list<string>,
     *         stream?: bool,
     *         system?: string|list<TextBlockParam>,
     *         temperature?: float,
     *         thinking?: ThinkingConfigEnabled|ThinkingConfigDisabled,
     *         toolChoice?: ToolChoiceAuto|ToolChoiceAny|ToolChoiceTool|ToolChoiceNone,
     *         tools?: list<Tool|ToolBash20250124|ToolTextEditor20250124|array{
     *
     * name?: string, type?: string, cacheControl?: CacheControlEphemeral
     *
     * }|WebSearchTool20250305>,
     *         topK?: int,
     *         topP?: float,
     *
     * },
     *
     * }> $requests
     */
    #[Api(type: new ListOf(new ListOf('mixed')))]
    public array $requests;
}

CreateParams::_loadMetadata();
