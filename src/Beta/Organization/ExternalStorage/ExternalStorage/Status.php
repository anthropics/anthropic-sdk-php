<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage\ExternalStorage;

use Anthropic\Beta\Organization\ExternalStorage\ActiveExternalStorageStatus;
use Anthropic\Beta\Organization\ExternalStorage\AvailableExternalStorageStatus;
use Anthropic\Beta\Organization\ExternalStorage\DrainingExternalStorageStatus;
use Anthropic\Beta\Organization\ExternalStorage\PendingConfigurationExternalStorageStatus;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type PendingConfigurationExternalStorageStatusShape from \Anthropic\Beta\Organization\ExternalStorage\PendingConfigurationExternalStorageStatus
 * @phpstan-import-type AvailableExternalStorageStatusShape from \Anthropic\Beta\Organization\ExternalStorage\AvailableExternalStorageStatus
 * @phpstan-import-type ActiveExternalStorageStatusShape from \Anthropic\Beta\Organization\ExternalStorage\ActiveExternalStorageStatus
 * @phpstan-import-type DrainingExternalStorageStatusShape from \Anthropic\Beta\Organization\ExternalStorage\DrainingExternalStorageStatus
 *
 * @phpstan-type StatusVariants = PendingConfigurationExternalStorageStatus|AvailableExternalStorageStatus|ActiveExternalStorageStatus|DrainingExternalStorageStatus
 * @phpstan-type StatusShape = StatusVariants|PendingConfigurationExternalStorageStatusShape|AvailableExternalStorageStatusShape|ActiveExternalStorageStatusShape|DrainingExternalStorageStatusShape
 */
final class Status implements ConverterSource
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
            'pending_configuration' => PendingConfigurationExternalStorageStatus::class,
            'available' => AvailableExternalStorageStatus::class,
            'active' => ActiveExternalStorageStatus::class,
            'draining' => DrainingExternalStorageStatus::class,
        ];
    }
}
