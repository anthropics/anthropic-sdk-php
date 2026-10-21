<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaSystemMessageParam\Content;

use Anthropic\Beta\Messages\BetaCacheControlEphemeral;
use Anthropic\Beta\Messages\BetaRequestToolAdditionBlock;
use Anthropic\Beta\Messages\BetaRequestToolRemovalBlock;
use Anthropic\Beta\Messages\BetaSystemMessageParam\Content\Block\Type;
use Anthropic\Beta\Messages\BetaTextBlockParam;
use Anthropic\Beta\Messages\BetaToolChangeMCPToolReference;
use Anthropic\Beta\Messages\BetaToolChangeMCPToolsetReference;
use Anthropic\Beta\Messages\BetaToolChangeToolDefinitionParam;
use Anthropic\Beta\Messages\BetaToolChangeToolReference;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaTextBlockParamShape from \Anthropic\Beta\Messages\BetaTextBlockParam
 * @phpstan-import-type BetaRequestToolAdditionBlockShape from \Anthropic\Beta\Messages\BetaRequestToolAdditionBlock
 * @phpstan-import-type BetaRequestToolRemovalBlockShape from \Anthropic\Beta\Messages\BetaRequestToolRemovalBlock
 * @phpstan-import-type BetaCacheControlEphemeralShape from \Anthropic\Beta\Messages\BetaCacheControlEphemeral
 * @phpstan-import-type BetaTextCitationParamShape from \Anthropic\Beta\Messages\BetaTextCitationParam
 * @phpstan-import-type ToolShape from \Anthropic\Beta\Messages\BetaRequestToolAdditionBlock\Tool
 * @phpstan-import-type ToolShape from \Anthropic\Beta\Messages\BetaRequestToolRemovalBlock\Tool as ToolShape1
 *
 * @phpstan-type BlockVariants = BetaTextBlockParam|BetaRequestToolAdditionBlock|BetaRequestToolRemovalBlock
 * @phpstan-type BlockShape = BlockVariants|BetaTextBlockParamShape|BetaRequestToolAdditionBlockShape|BetaRequestToolRemovalBlockShape
 */
final class Block implements ConverterSource
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

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param BetaCacheControlEphemeral|BetaCacheControlEphemeralShape|null $cacheControl
     * @param list<BetaTextCitationParamShape>|null $citations
     * @param ($type is Type::TOOL_ADDITION|'tool_addition' ? ToolShape|null : ToolShape1|null) $tool
     *
     * @return ($type is Type::TEXT|'text' ? BetaTextBlockParam : ($type is Type::TOOL_ADDITION|'tool_addition' ? BetaRequestToolAdditionBlock : ($type is Type::TOOL_REMOVAL|'tool_removal' ? BetaRequestToolRemovalBlock : BetaTextBlockParam|BetaRequestToolAdditionBlock|BetaRequestToolRemovalBlock)))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $text = null,
        BetaCacheControlEphemeral|array|null $cacheControl = null,
        ?array $citations = null,
        BetaToolChangeToolReference|array|BetaToolChangeMCPToolReference|BetaToolChangeMCPToolsetReference|BetaToolChangeToolDefinitionParam|null $tool = null,
    ): BetaTextBlockParam|BetaRequestToolAdditionBlock|BetaRequestToolRemovalBlock {
        return match ($type) {
            Type::TEXT, 'text' => BetaTextBlockParam::with(
                text: $text ?? throw new \ArgumentCountError('$text is required'),
                cacheControl: $cacheControl,
                citations: $citations,
            ),
            Type::TOOL_ADDITION, 'tool_addition' => BetaRequestToolAdditionBlock::with(
                // @phpstan-ignore argument.type
                tool: $tool ?? throw new \ArgumentCountError('$tool is required'),
                cacheControl: $cacheControl,
            ),
            Type::TOOL_REMOVAL, 'tool_removal' => BetaRequestToolRemovalBlock::with(
                // @phpstan-ignore argument.type
                tool: $tool ?? throw new \ArgumentCountError('$tool is required'),
                cacheControl: $cacheControl,
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
