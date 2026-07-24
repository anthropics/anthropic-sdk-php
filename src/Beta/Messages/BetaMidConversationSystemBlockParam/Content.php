<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaMidConversationSystemBlockParam;

use Anthropic\Beta\Messages\BetaRequestToolAdditionBlock;
use Anthropic\Beta\Messages\BetaRequestToolRemovalBlock;
use Anthropic\Beta\Messages\BetaTextBlockParam;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Mid-conversation directive to surface a declared tool.
 *
 * ``tool`` references a tool (or MCP toolset) by name from the request's
 * ``tools``; it is offered to the model from this point in the
 * conversation onward.
 *
 * @phpstan-import-type BetaTextBlockParamShape from \Anthropic\Beta\Messages\BetaTextBlockParam
 * @phpstan-import-type BetaRequestToolAdditionBlockShape from \Anthropic\Beta\Messages\BetaRequestToolAdditionBlock
 * @phpstan-import-type BetaRequestToolRemovalBlockShape from \Anthropic\Beta\Messages\BetaRequestToolRemovalBlock
 *
 * @phpstan-type ContentVariants = BetaTextBlockParam|BetaRequestToolAdditionBlock|BetaRequestToolRemovalBlock
 * @phpstan-type ContentShape = ContentVariants|BetaTextBlockParamShape|BetaRequestToolAdditionBlockShape|BetaRequestToolRemovalBlockShape
 */
final class Content implements ConverterSource
{
    use SdkUnion;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            'text' => BetaTextBlockParam::class,
            'tool_addition' => BetaRequestToolAdditionBlock::class,
            'tool_removal' => BetaRequestToolRemovalBlock::class,
        ];
    }
}
