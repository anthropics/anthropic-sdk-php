<?php

declare(strict_types=1);

namespace Anthropic\Beta\Files\DeletedFile;

use Anthropic\Core\Concerns\Enum;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Deleted object type.
 *
 * For file deletion, this is always `"file_deleted"`.
 *
 * @phpstan-type type_alias = Type::*
 */
final class Type implements ConverterSource
{
    use Enum;

    public const FILE_DELETED = 'file_deleted';
}
