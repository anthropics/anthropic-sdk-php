<?php

declare(strict_types=1);

namespace Anthropic\Beta\Files\DeletedFile;

/**
 * Deleted object type.
 *
 * For file deletion, this is always `"file_deleted"`.
 */
enum Type: string
{
    case FILE_DELETED = 'file_deleted';
}
