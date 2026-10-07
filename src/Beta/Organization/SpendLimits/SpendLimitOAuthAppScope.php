<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\SpendLimits;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Scope selecting one OAuth app whose API requests are billed to a Claude
 * Console organization.
 *
 * @phpstan-type SpendLimitOAuthAppScopeShape = array{
 *   oauthAppID: string, type: 'oauth_app'
 * }
 */
final class SpendLimitOAuthAppScope implements BaseModel
{
    /** @use SdkModel<SpendLimitOAuthAppScopeShape> */
    use SdkModel;

    /**
     * Scope type. Always `oauth_app` for this scope.
     *
     * @var 'oauth_app' $type
     */
    #[Required(type: new ConstantOf('oauth_app'))]
    public string $type = 'oauth_app';

    /**
     * ID of the OAuth app the spend limit applies to (`clid_...`).
     */
    #[Required('oauth_app_id')]
    public string $oauthAppID;

    /**
     * `new SpendLimitOAuthAppScope()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SpendLimitOAuthAppScope::with(oauthAppID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SpendLimitOAuthAppScope())->withOAuthAppID(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(string $oauthAppID): self
    {
        $self = new self;

        $self['oauthAppID'] = $oauthAppID;

        return $self;
    }

    /**
     * ID of the OAuth app the spend limit applies to (`clid_...`).
     */
    public function withOAuthAppID(string $oauthAppID): self
    {
        $self = clone $this;
        $self['oauthAppID'] = $oauthAppID;

        return $self;
    }

    /**
     * Scope type. Always `oauth_app` for this scope.
     *
     * @param 'oauth_app' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
