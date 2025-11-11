<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

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
