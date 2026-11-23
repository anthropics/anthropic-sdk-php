<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces;

use Anthropic\Beta\Organization\Workspaces\StorageMemberParam\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type InternalStorageParamShape from \Anthropic\Beta\Organization\Workspaces\InternalStorageParam
 * @phpstan-import-type ExternalStorageMemberParamShape from \Anthropic\Beta\Organization\Workspaces\ExternalStorageMemberParam
 *
 * @phpstan-type StorageMemberParamVariants = InternalStorageParam|ExternalStorageMemberParam
 * @phpstan-type StorageMemberParamShape = StorageMemberParamVariants|InternalStorageParamShape|ExternalStorageMemberParamShape
 */
final class StorageMemberParam implements ConverterSource
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
            'internal' => InternalStorageParam::class,
            'external' => ExternalStorageMemberParam::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::INTERNAL|'internal' ? InternalStorageParam : ($type is Type::EXTERNAL|'external' ? ExternalStorageMemberParam : InternalStorageParam|ExternalStorageMemberParam))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $externalStorageID = null
    ): InternalStorageParam|ExternalStorageMemberParam {
        return match ($type) {
            Type::INTERNAL, 'internal' => InternalStorageParam::with(),
            Type::EXTERNAL, 'external' => ExternalStorageMemberParam::with(
                externalStorageID: $externalStorageID ?? throw new \ArgumentCountError('$externalStorageID is required'),
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
