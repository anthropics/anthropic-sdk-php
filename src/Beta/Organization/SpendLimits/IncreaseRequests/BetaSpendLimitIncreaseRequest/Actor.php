<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\SpendLimits\IncreaseRequests\BetaSpendLimitIncreaseRequest;

use Anthropic\Beta\Organization\SpendLimits\SpendLimitScopedAPIKeyActor;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitUserActor;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type SpendLimitUserActorShape from \Anthropic\Beta\Organization\SpendLimits\SpendLimitUserActor
 * @phpstan-import-type SpendLimitScopedAPIKeyActorShape from \Anthropic\Beta\Organization\SpendLimits\SpendLimitScopedAPIKeyActor
 *
 * @phpstan-type ActorVariants = SpendLimitUserActor|SpendLimitScopedAPIKeyActor
 * @phpstan-type ActorShape = ActorVariants|SpendLimitUserActorShape|SpendLimitScopedAPIKeyActorShape
 */
final class Actor implements ConverterSource
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
            'user_actor' => SpendLimitUserActor::class,
            'scoped_api_key_actor' => SpendLimitScopedAPIKeyActor::class,
        ];
    }
}
