<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\SessionCreateParams;

use Anthropic\Beta\Sessions\Events\ManagedAgentsFileRubricParams;
use Anthropic\Beta\Sessions\Events\ManagedAgentsTextRubricParams;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUserDefineOutcomeEventParams;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUserMessageEventParams;
use Anthropic\Beta\Sessions\SessionCreateParams\InitialEvent\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * An event sent to the `session` immediately after it is created. Supports `user.message` and `user.define_outcome`.
 *
 * @phpstan-import-type ManagedAgentsUserMessageEventParamsShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserMessageEventParams
 * @phpstan-import-type ManagedAgentsUserDefineOutcomeEventParamsShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserDefineOutcomeEventParams
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserMessageEventParams\Content
 * @phpstan-import-type RubricShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserDefineOutcomeEventParams\Rubric
 *
 * @phpstan-type InitialEventVariants = ManagedAgentsUserMessageEventParams|ManagedAgentsUserDefineOutcomeEventParams
 * @phpstan-type InitialEventShape = InitialEventVariants|ManagedAgentsUserMessageEventParamsShape|ManagedAgentsUserDefineOutcomeEventParamsShape
 */
final class InitialEvent implements ConverterSource
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
            'user.message' => ManagedAgentsUserMessageEventParams::class,
            'user.define_outcome' => ManagedAgentsUserDefineOutcomeEventParams::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param list<ContentShape>|null $content
     * @param RubricShape|null $rubric
     *
     * @return ($type is Type::USER_MESSAGE|'user.message' ? ManagedAgentsUserMessageEventParams : ($type is Type::USER_DEFINE_OUTCOME|'user.define_outcome' ? ManagedAgentsUserDefineOutcomeEventParams : ManagedAgentsUserMessageEventParams|ManagedAgentsUserDefineOutcomeEventParams))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?array $content = null,
        ?string $description = null,
        ManagedAgentsFileRubricParams|array|ManagedAgentsTextRubricParams|null $rubric = null,
        ?int $maxIterations = null,
    ): ManagedAgentsUserMessageEventParams|ManagedAgentsUserDefineOutcomeEventParams {
        return match ($type) {
            Type::USER_MESSAGE, 'user.message' => ManagedAgentsUserMessageEventParams::with(
                type: 'user.message',
                content: $content ?? throw new \ArgumentCountError('$content is required'),
            ),
            Type::USER_DEFINE_OUTCOME, 'user.define_outcome' => ManagedAgentsUserDefineOutcomeEventParams::with(
                type: 'user.define_outcome',
                description: $description ?? throw new \ArgumentCountError('$description is required'),
                rubric: $rubric ?? throw new \ArgumentCountError('$rubric is required'),
                maxIterations: $maxIterations,
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
