<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\MemoryVersions;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Identifies who performed an operation. Recorded when the operation happens and not updated afterwards, so the ID may refer to a user, service account, API key, or session that has since been deleted.
 *
 * @phpstan-import-type ManagedAgentsSessionActorShape from \Anthropic\Beta\MemoryStores\MemoryVersions\ManagedAgentsSessionActor
 * @phpstan-import-type ManagedAgentsAPIActorShape from \Anthropic\Beta\MemoryStores\MemoryVersions\ManagedAgentsAPIActor
 * @phpstan-import-type ManagedAgentsUserActorShape from \Anthropic\Beta\MemoryStores\MemoryVersions\ManagedAgentsUserActor
 * @phpstan-import-type ManagedAgentsServiceAccountActorShape from \Anthropic\Beta\MemoryStores\MemoryVersions\ManagedAgentsServiceAccountActor
 *
 * @phpstan-type ManagedAgentsActorVariants = ManagedAgentsSessionActor|ManagedAgentsAPIActor|ManagedAgentsUserActor|ManagedAgentsServiceAccountActor
 * @phpstan-type ManagedAgentsActorShape = ManagedAgentsActorVariants|ManagedAgentsSessionActorShape|ManagedAgentsAPIActorShape|ManagedAgentsUserActorShape|ManagedAgentsServiceAccountActorShape
 */
final class ManagedAgentsActor implements ConverterSource
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
            'session_actor' => ManagedAgentsSessionActor::class,
            'api_actor' => ManagedAgentsAPIActor::class,
            'user_actor' => ManagedAgentsUserActor::class,
            'service_account_actor' => ManagedAgentsServiceAccountActor::class,
        ];
    }
}
