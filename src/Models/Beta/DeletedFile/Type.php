<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\DeletedFile;

use Anthropic\Core\Concerns\Enum;
use Anthropic\Core\Contracts\StaticConverter;

final class Type implements StaticConverter
{
    use Enum;

    final public const FILE_DELETED = 'file_deleted';
}
