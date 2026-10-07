<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\SpendLimits;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Scope selecting each OAuth app that has no `oauth_app` limit of its own.
 * Each of those apps is limited separately.
 *
 * @phpstan-type SpendLimitOAuthAppDefaultScopeShape = array{
 *   type: 'oauth_app_default'
 * }
 */
final class SpendLimitOAuthAppDefaultScope implements BaseModel
{
    /** @use SdkModel<SpendLimitOAuthAppDefaultScopeShape> */
    use SdkModel;

    /**
     * Scope type. Always `oauth_app_default` for this scope.
     *
     * @var 'oauth_app_default' $type
     */
    #[Required(type: new ConstantOf('oauth_app_default'))]
    public string $type = 'oauth_app_default';

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(): self
    {
        return new self;
    }

    /**
     * Scope type. Always `oauth_app_default` for this scope.
     *
     * @param 'oauth_app_default' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
