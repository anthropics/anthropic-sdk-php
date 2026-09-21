<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments;

use Anthropic\Beta\Deployments\BetaManagedAgentsDeploymentInitialEvent\Type;
use Anthropic\Beta\Sessions\BetaManagedAgentsSystemContentBlock;
use Anthropic\Beta\Sessions\Events\ManagedAgentsFileRubric;
use Anthropic\Beta\Sessions\Events\ManagedAgentsTextRubric;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * An event sent to a session immediately after it is created. Supports `user.message`, `user.define_outcome`, and `system.message`.
 *
 * @phpstan-import-type BetaManagedAgentsDeploymentUserMessageEventShape from \Anthropic\Beta\Deployments\BetaManagedAgentsDeploymentUserMessageEvent
 * @phpstan-import-type BetaManagedAgentsDeploymentUserDefineOutcomeEventShape from \Anthropic\Beta\Deployments\BetaManagedAgentsDeploymentUserDefineOutcomeEvent
 * @phpstan-import-type BetaManagedAgentsDeploymentSystemMessageEventShape from \Anthropic\Beta\Deployments\BetaManagedAgentsDeploymentSystemMessageEvent
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Deployments\BetaManagedAgentsDeploymentUserMessageEvent\Content
 * @phpstan-import-type BetaManagedAgentsSystemContentBlockShape from \Anthropic\Beta\Sessions\BetaManagedAgentsSystemContentBlock
 * @phpstan-import-type RubricShape from \Anthropic\Beta\Deployments\BetaManagedAgentsDeploymentUserDefineOutcomeEvent\Rubric
 *
 * @phpstan-type BetaManagedAgentsDeploymentInitialEventVariants = BetaManagedAgentsDeploymentUserMessageEvent|BetaManagedAgentsDeploymentUserDefineOutcomeEvent|BetaManagedAgentsDeploymentSystemMessageEvent
 * @phpstan-type BetaManagedAgentsDeploymentInitialEventShape = BetaManagedAgentsDeploymentInitialEventVariants|BetaManagedAgentsDeploymentUserMessageEventShape|BetaManagedAgentsDeploymentUserDefineOutcomeEventShape|BetaManagedAgentsDeploymentSystemMessageEventShape
 */
final class BetaManagedAgentsDeploymentInitialEvent implements ConverterSource
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
            'user.message' => BetaManagedAgentsDeploymentUserMessageEvent::class,
            'user.define_outcome' => BetaManagedAgentsDeploymentUserDefineOutcomeEvent::class,
            'system.message' => BetaManagedAgentsDeploymentSystemMessageEvent::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param ($type is Type::USER_MESSAGE|'user.message' ? list<ContentShape>|null : list<BetaManagedAgentsSystemContentBlock|BetaManagedAgentsSystemContentBlockShape>|null) $content
     * @param RubricShape|null $rubric
     *
     * @return ($type is Type::USER_MESSAGE|'user.message' ? BetaManagedAgentsDeploymentUserMessageEvent : ($type is Type::USER_DEFINE_OUTCOME|'user.define_outcome' ? BetaManagedAgentsDeploymentUserDefineOutcomeEvent : ($type is Type::SYSTEM_MESSAGE|'system.message' ? BetaManagedAgentsDeploymentSystemMessageEvent : BetaManagedAgentsDeploymentUserMessageEvent|BetaManagedAgentsDeploymentUserDefineOutcomeEvent|BetaManagedAgentsDeploymentSystemMessageEvent)))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?array $content = null,
        ?string $description = null,
        ManagedAgentsFileRubric|array|ManagedAgentsTextRubric|null $rubric = null,
        ?int $maxIterations = null,
    ): BetaManagedAgentsDeploymentUserMessageEvent|BetaManagedAgentsDeploymentUserDefineOutcomeEvent|BetaManagedAgentsDeploymentSystemMessageEvent {
        return match ($type) {
            Type::USER_MESSAGE, 'user.message' => BetaManagedAgentsDeploymentUserMessageEvent::with(
                type: 'user.message',
                content: $content ?? throw new \ArgumentCountError('$content is required'),
            ),
            Type::USER_DEFINE_OUTCOME, 'user.define_outcome' => BetaManagedAgentsDeploymentUserDefineOutcomeEvent::with(
                type: 'user.define_outcome',
                description: $description ?? throw new \ArgumentCountError('$description is required'),
                rubric: $rubric ?? throw new \ArgumentCountError('$rubric is required'),
                maxIterations: $maxIterations,
            ),
            Type::SYSTEM_MESSAGE, 'system.message' => BetaManagedAgentsDeploymentSystemMessageEvent::with(
                type: 'system.message',
                // @phpstan-ignore argument.type
                content: $content ?? throw new \ArgumentCountError('$content is required'),
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
