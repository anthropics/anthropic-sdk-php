<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\BetaMessageParam;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Contracts\Converter;
use Anthropic\Core\Contracts\StaticConverter;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;
use Anthropic\Models\Beta\BetaCodeExecutionToolResultBlockParam;
use Anthropic\Models\Beta\BetaContainerUploadBlockParam;
use Anthropic\Models\Beta\BetaImageBlockParam;
use Anthropic\Models\Beta\BetaMCPToolUseBlockParam;
use Anthropic\Models\Beta\BetaRedactedThinkingBlockParam;
use Anthropic\Models\Beta\BetaRequestDocumentBlock;
use Anthropic\Models\Beta\BetaRequestMCPToolResultBlockParam;
use Anthropic\Models\Beta\BetaSearchResultBlockParam;
use Anthropic\Models\Beta\BetaServerToolUseBlockParam;
use Anthropic\Models\Beta\BetaTextBlockParam;
use Anthropic\Models\Beta\BetaThinkingBlockParam;
use Anthropic\Models\Beta\BetaToolResultBlockParam;
use Anthropic\Models\Beta\BetaToolUseBlockParam;
use Anthropic\Models\Beta\BetaWebSearchToolResultBlockParam;

final class Content implements StaticConverter
{
    use Union;

    /**
     * @return list<string|Converter|StaticConverter>|array<
     *   string, string|Converter|StaticConverter
     * >
     */
    public static function variants(): array
    {
        return [
            'string',
            new ListOf(
                new UnionOf(
                    [
                        BetaTextBlockParam::class,
                        BetaImageBlockParam::class,
                        BetaRequestDocumentBlock::class,
                        BetaSearchResultBlockParam::class,
                        BetaThinkingBlockParam::class,
                        BetaRedactedThinkingBlockParam::class,
                        BetaToolUseBlockParam::class,
                        BetaToolResultBlockParam::class,
                        BetaServerToolUseBlockParam::class,
                        BetaWebSearchToolResultBlockParam::class,
                        BetaCodeExecutionToolResultBlockParam::class,
                        BetaMCPToolUseBlockParam::class,
                        BetaRequestMCPToolResultBlockParam::class,
                        BetaContainerUploadBlockParam::class,
                    ],
                ),
            ),
        ];
    }
}
