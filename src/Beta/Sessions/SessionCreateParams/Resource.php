<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\SessionCreateParams;

use Anthropic\Beta\Sessions\BetaManagedAgentsFileResourceParams;
use Anthropic\Beta\Sessions\BetaManagedAgentsGitHubRepositoryResourceParams;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Union of resources that can be mounted into a session.
 *
 * @phpstan-import-type BetaManagedAgentsGitHubRepositoryResourceParamsShape from \Anthropic\Beta\Sessions\BetaManagedAgentsGitHubRepositoryResourceParams
 * @phpstan-import-type BetaManagedAgentsFileResourceParamsShape from \Anthropic\Beta\Sessions\BetaManagedAgentsFileResourceParams
 *
 * @phpstan-type ResourceVariants = BetaManagedAgentsGitHubRepositoryResourceParams|BetaManagedAgentsFileResourceParams
 * @phpstan-type ResourceShape = ResourceVariants|BetaManagedAgentsGitHubRepositoryResourceParamsShape|BetaManagedAgentsFileResourceParamsShape
 */
final class Resource implements ConverterSource
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
            'github_repository' => BetaManagedAgentsGitHubRepositoryResourceParams::class,
            'file' => BetaManagedAgentsFileResourceParams::class,
        ];
    }
}
