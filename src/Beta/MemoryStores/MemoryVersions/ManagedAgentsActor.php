<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\MemoryVersions;

use Anthropic\Beta\MemoryStores\MemoryVersions\ManagedAgentsActor\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Identifies who performed a write or redact operation. Captured at write time on the `memory_version` row. The API key that created a session is not recorded on agent writes; attribution answers who made the write, not who is ultimately responsible. Look up session provenance separately via the [Sessions API](/en/api/beta/sessions/retrieve).
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

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::SESSION_ACTOR|'session_actor' ? ManagedAgentsSessionActor : ($type is Type::API_ACTOR|'api_actor' ? ManagedAgentsAPIActor : ($type is Type::USER_ACTOR|'user_actor' ? ManagedAgentsUserActor : ($type is Type::SERVICE_ACCOUNT_ACTOR|'service_account_actor' ? ManagedAgentsServiceAccountActor : ManagedAgentsSessionActor|ManagedAgentsAPIActor|ManagedAgentsUserActor|ManagedAgentsServiceAccountActor))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $sessionID = null,
        ?string $apiKeyID = null,
        ?string $userID = null,
        ?string $serviceAccountID = null,
    ): ManagedAgentsSessionActor|ManagedAgentsAPIActor|ManagedAgentsUserActor|ManagedAgentsServiceAccountActor {
        return match ($type) {
            Type::SESSION_ACTOR, 'session_actor' => ManagedAgentsSessionActor::with(
                type: 'session_actor',
                sessionID: $sessionID ?? throw new \ArgumentCountError('$sessionID is required'),
            ),
            Type::API_ACTOR, 'api_actor' => ManagedAgentsAPIActor::with(
                type: 'api_actor',
                apiKeyID: $apiKeyID ?? throw new \ArgumentCountError('$apiKeyID is required'),
            ),
            Type::USER_ACTOR, 'user_actor' => ManagedAgentsUserActor::with(
                type: 'user_actor',
                userID: $userID ?? throw new \ArgumentCountError('$userID is required'),
            ),
            Type::SERVICE_ACCOUNT_ACTOR, 'service_account_actor' => ManagedAgentsServiceAccountActor::with(
                serviceAccountID: $serviceAccountID ?? throw new \ArgumentCountError('$serviceAccountID is required'),
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
