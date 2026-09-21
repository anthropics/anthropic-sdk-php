<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaMemoryTool20250818Command\Command;
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

    /**
     * Constructs the variant whose `command` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param list<int>|null $viewRange
     *
     * @return ($command is Command::VIEW|'view' ? BetaMemoryTool20250818ViewCommand : ($command is Command::CREATE|'create' ? BetaMemoryTool20250818CreateCommand : ($command is Command::STR_REPLACE|'str_replace' ? BetaMemoryTool20250818StrReplaceCommand : ($command is Command::INSERT|'insert' ? BetaMemoryTool20250818InsertCommand : ($command is Command::DELETE|'delete' ? BetaMemoryTool20250818DeleteCommand : ($command is Command::RENAME|'rename' ? BetaMemoryTool20250818RenameCommand : BetaMemoryTool20250818ViewCommand|BetaMemoryTool20250818CreateCommand|BetaMemoryTool20250818StrReplaceCommand|BetaMemoryTool20250818InsertCommand|BetaMemoryTool20250818DeleteCommand|BetaMemoryTool20250818RenameCommand))))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Command|string $command,
        ?string $path = null,
        ?array $viewRange = null,
        ?string $fileText = null,
        ?string $newStr = null,
        ?string $oldStr = null,
        ?int $insertLine = null,
        ?string $insertText = null,
        ?string $newPath = null,
        ?string $oldPath = null,
    ): BetaMemoryTool20250818ViewCommand|BetaMemoryTool20250818CreateCommand|BetaMemoryTool20250818StrReplaceCommand|BetaMemoryTool20250818InsertCommand|BetaMemoryTool20250818DeleteCommand|BetaMemoryTool20250818RenameCommand {
        return match ($command) {
            Command::VIEW, 'view' => BetaMemoryTool20250818ViewCommand::with(
                path: $path ?? throw new \ArgumentCountError('$path is required'),
                viewRange: $viewRange,
            ),
            Command::CREATE, 'create' => BetaMemoryTool20250818CreateCommand::with(
                fileText: $fileText ?? throw new \ArgumentCountError('$fileText is required'),
                path: $path ?? throw new \ArgumentCountError('$path is required'),
            ),
            Command::STR_REPLACE, 'str_replace' => BetaMemoryTool20250818StrReplaceCommand::with(
                newStr: $newStr ?? throw new \ArgumentCountError('$newStr is required'),
                oldStr: $oldStr ?? throw new \ArgumentCountError('$oldStr is required'),
                path: $path ?? throw new \ArgumentCountError('$path is required'),
            ),
            Command::INSERT, 'insert' => BetaMemoryTool20250818InsertCommand::with(
                insertLine: $insertLine ?? throw new \ArgumentCountError('$insertLine is required'),
                insertText: $insertText ?? throw new \ArgumentCountError('$insertText is required'),
                path: $path ?? throw new \ArgumentCountError('$path is required'),
            ),
            Command::DELETE, 'delete' => BetaMemoryTool20250818DeleteCommand::with(
                path: $path ?? throw new \ArgumentCountError('$path is required')
            ),
            Command::RENAME, 'rename' => BetaMemoryTool20250818RenameCommand::with(
                newPath: $newPath ?? throw new \ArgumentCountError('$newPath is required'),
                oldPath: $oldPath ?? throw new \ArgumentCountError('$oldPath is required'),
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($command, true)))
        };
    }
}
