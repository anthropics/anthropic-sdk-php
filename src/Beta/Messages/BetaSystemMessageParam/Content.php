<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaSystemMessageParam;

use Anthropic\Beta\Messages\BetaRequestToolAdditionBlock;
use Anthropic\Beta\Messages\BetaRequestToolRemovalBlock;
use Anthropic\Beta\Messages\BetaSystemMessageParam\Content\Block;
use Anthropic\Beta\Messages\BetaTextBlockParam;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;

/**
 * @phpstan-import-type BlockShape from \Anthropic\Beta\Messages\BetaSystemMessageParam\Content\Block
 *
 * @phpstan-type ContentVariants = string|list<BetaTextBlockParam|BetaRequestToolAdditionBlock|BetaRequestToolRemovalBlock>
 * @phpstan-type ContentShape = ContentVariants|list<BlockShape>
 */
final class Content implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return ['string', new ListOf(Block::class)];
    }
}
