<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments;

use Anthropic\Beta\Deployments\BetaManagedAgentsDeploymentPausedReason\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Why a deployment is paused. Non-null exactly when `status` is `paused`.
 *
 * @phpstan-import-type BetaManagedAgentsManualDeploymentPausedReasonShape from \Anthropic\Beta\Deployments\BetaManagedAgentsManualDeploymentPausedReason
 * @phpstan-import-type BetaManagedAgentsErrorDeploymentPausedReasonShape from \Anthropic\Beta\Deployments\BetaManagedAgentsErrorDeploymentPausedReason
 * @phpstan-import-type BetaManagedAgentsDeploymentPausedReasonErrorShape from \Anthropic\Beta\Deployments\BetaManagedAgentsDeploymentPausedReasonError
 *
 * @phpstan-type BetaManagedAgentsDeploymentPausedReasonVariants = BetaManagedAgentsManualDeploymentPausedReason|BetaManagedAgentsErrorDeploymentPausedReason
 * @phpstan-type BetaManagedAgentsDeploymentPausedReasonShape = BetaManagedAgentsDeploymentPausedReasonVariants|BetaManagedAgentsManualDeploymentPausedReasonShape|BetaManagedAgentsErrorDeploymentPausedReasonShape
 */
final class BetaManagedAgentsDeploymentPausedReason implements ConverterSource
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
            'manual' => BetaManagedAgentsManualDeploymentPausedReason::class,
            'error' => BetaManagedAgentsErrorDeploymentPausedReason::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param BetaManagedAgentsDeploymentPausedReasonErrorShape|null $error
     *
     * @return ($type is Type::MANUAL|'manual' ? BetaManagedAgentsManualDeploymentPausedReason : ($type is Type::ERROR|'error' ? BetaManagedAgentsErrorDeploymentPausedReason : BetaManagedAgentsManualDeploymentPausedReason|BetaManagedAgentsErrorDeploymentPausedReason))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        BetaManagedAgentsEnvironmentArchivedDeploymentPausedReasonError|array|BetaManagedAgentsAgentArchivedDeploymentPausedReasonError|BetaManagedAgentsEnvironmentNotFoundDeploymentPausedReasonError|BetaManagedAgentsVaultNotFoundDeploymentPausedReasonError|BetaManagedAgentsFileNotFoundDeploymentPausedReasonError|BetaManagedAgentsSessionResourceNotFoundDeploymentPausedReasonError|BetaManagedAgentsWorkspaceArchivedDeploymentPausedReasonError|BetaManagedAgentsOrganizationDisabledDeploymentPausedReasonError|BetaManagedAgentsMemoryStoreArchivedDeploymentPausedReasonError|BetaManagedAgentsSkillNotFoundDeploymentPausedReasonError|BetaManagedAgentsVaultArchivedDeploymentPausedReasonError|BetaManagedAgentsUnknownDeploymentPausedReasonError|BetaManagedAgentsSelfHostedResourcesUnsupportedDeploymentPausedReasonError|BetaManagedAgentsMCPEgressBlockedDeploymentPausedReasonError|null $error = null,
    ): BetaManagedAgentsManualDeploymentPausedReason|BetaManagedAgentsErrorDeploymentPausedReason {
        return match ($type) {
            Type::MANUAL, 'manual' => BetaManagedAgentsManualDeploymentPausedReason::with(
                type: 'manual'
            ),
            Type::ERROR, 'error' => BetaManagedAgentsErrorDeploymentPausedReason::with(
                type: 'error',
                error: $error ?? throw new \ArgumentCountError('$error is required'),
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
