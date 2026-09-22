<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaMemoryTool20250818ViewCommandShape from \Anthropic\Beta\Messages\BetaMemoryTool20250818ViewCommand
 * @phpstan-import-type BetaMemoryTool20250818CreateCommandShape from \Anthropic\Beta\Messages\BetaMemoryTool20250818CreateCommand
 * @phpstan-import-type BetaMemoryTool20250818StrReplaceCommandShape from \Anthropic\Beta\Messages\BetaMemoryTool20250818StrReplaceCommand
 * @phpstan-import-type BetaMemoryTool20250818InsertCommandShape from \Anthropic\Beta\Messages\BetaMemoryTool20250818InsertCommand
 * @phpstan-import-type BetaMemoryTool20250818DeleteCommandShape from \Anthropic\Beta\Messages\BetaMemoryTool20250818DeleteCommand
 * @phpstan-import-type BetaMemoryTool20250818RenameCommandShape from \Anthropic\Beta\Messages\BetaMemoryTool20250818RenameCommand
 *
 * @phpstan-type BetaMemoryTool20250818CommandVariants = BetaMemoryTool20250818ViewCommand|BetaMemoryTool20250818CreateCommand|BetaMemoryTool20250818StrReplaceCommand|BetaMemoryTool20250818InsertCommand|BetaMemoryTool20250818DeleteCommand|BetaMemoryTool20250818RenameCommand
 * @phpstan-type BetaMemoryTool20250818CommandShape = BetaMemoryTool20250818CommandVariants|BetaMemoryTool20250818ViewCommandShape|BetaMemoryTool20250818CreateCommandShape|BetaMemoryTool20250818StrReplaceCommandShape|BetaMemoryTool20250818InsertCommandShape|BetaMemoryTool20250818DeleteCommandShape|BetaMemoryTool20250818RenameCommandShape
 */
final class BetaMemoryTool20250818Command implements ConverterSource
{
    use SdkUnion;

    public static function discriminator(): string
    {
        return 'command';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            'view' => BetaMemoryTool20250818ViewCommand::class,
            'create' => BetaMemoryTool20250818CreateCommand::class,
            'str_replace' => BetaMemoryTool20250818StrReplaceCommand::class,
            'insert' => BetaMemoryTool20250818InsertCommand::class,
            'delete' => BetaMemoryTool20250818DeleteCommand::class,
            'rename' => BetaMemoryTool20250818RenameCommand::class,
        ];
    }
}
