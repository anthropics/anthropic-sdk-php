<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type InternalStorageShape from \Anthropic\Beta\Organization\Workspaces\InternalStorage
 * @phpstan-import-type ExternalStorageMemberShape from \Anthropic\Beta\Organization\Workspaces\ExternalStorageMember
 *
 * @phpstan-type StorageMemberVariants = InternalStorage|ExternalStorageMember
 * @phpstan-type StorageMemberShape = StorageMemberVariants|InternalStorageShape|ExternalStorageMemberShape
 */
final class StorageMember implements ConverterSource
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
            'internal' => InternalStorage::class,
            'external' => ExternalStorageMember::class,
        ];
    }
}
