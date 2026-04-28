<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\MemoryVersions;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Identifies who performed a write or redact operation. Captured at write time on the `memory_version` row. The API key that created a session is not recorded on agent writes; attribution answers who made the write, not who is ultimately responsible. Look up session provenance separately via the [Sessions API](/en/api/sessions-retrieve).
 *
 * @phpstan-import-type ManagedAgentsSessionActorShape from \Anthropic\Beta\MemoryStores\MemoryVersions\ManagedAgentsSessionActor
 * @phpstan-import-type ManagedAgentsAPIActorShape from \Anthropic\Beta\MemoryStores\MemoryVersions\ManagedAgentsAPIActor
 * @phpstan-import-type ManagedAgentsUserActorShape from \Anthropic\Beta\MemoryStores\MemoryVersions\ManagedAgentsUserActor
 *
 * @phpstan-type ManagedAgentsActorVariants = ManagedAgentsSessionActor|ManagedAgentsAPIActor|ManagedAgentsUserActor
 * @phpstan-type ManagedAgentsActorShape = ManagedAgentsActorVariants|ManagedAgentsSessionActorShape|ManagedAgentsAPIActorShape|ManagedAgentsUserActorShape
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
        ];
    }
}
