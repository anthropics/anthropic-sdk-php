<?php

declare(strict_types=1);

namespace Anthropic\Organization\SpendLimits\IncreaseRequests;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Organization\SpendLimits\SpendLimitScopedAPIKeyActor;
use Anthropic\Organization\SpendLimits\SpendLimitUserActor;

/**
 * Who approved or denied the increase request.
 *
 * @phpstan-import-type SpendLimitUserActorShape from \Anthropic\Organization\SpendLimits\SpendLimitUserActor
 * @phpstan-import-type SpendLimitScopedAPIKeyActorShape from \Anthropic\Organization\SpendLimits\SpendLimitScopedAPIKeyActor
 *
 * @phpstan-type SpendLimitIncreaseRequestResolvedByVariants = SpendLimitUserActor|SpendLimitScopedAPIKeyActor
 * @phpstan-type SpendLimitIncreaseRequestResolvedByShape = SpendLimitIncreaseRequestResolvedByVariants|SpendLimitUserActorShape|SpendLimitScopedAPIKeyActorShape
 */
final class SpendLimitIncreaseRequestResolvedBy implements ConverterSource
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
