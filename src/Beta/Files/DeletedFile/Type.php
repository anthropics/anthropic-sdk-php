<?php

declare(strict_types=1);

namespace Anthropic\Beta\Files\DeletedFile;

use Anthropic\Core\Concerns\SdkEnum;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Deleted object type.
 *
 * For file deletion, this is always `"file_deleted"`.
 */
final class Type implements ConverterSource
{
    use SdkEnum;

    public const FILE_DELETED = 'file_deleted';
}
