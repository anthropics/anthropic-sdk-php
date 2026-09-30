<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\SpendLimits;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Scope selecting a single member of the organization.
 *
 * @phpstan-type SpendLimitUserScopeShape = array{type: 'user', userID: string}
 */
final class SpendLimitUserScope implements BaseModel
{
    /** @use SdkModel<SpendLimitUserScopeShape> */
    use SdkModel;

    /**
     * Scope type. Always `user` for this scope.
     *
     * @var 'user' $type
     */
    #[Required(type: new ConstantOf('user'))]
    public string $type = 'user';

    /**
     * Tagged ID of the member the spend limit applies to.
     */
    #[Required('user_id')]
    public string $userID;

    /**
     * `new SpendLimitUserScope()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SpendLimitUserScope::with(userID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SpendLimitUserScope)->withUserID(...)
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
    public static function with(string $userID): self
    {
        $self = new self;

        $self['userID'] = $userID;

        return $self;
    }

    /**
     * Scope type. Always `user` for this scope.
     *
     * @param 'user' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Tagged ID of the member the spend limit applies to.
     */
    public function withUserID(string $userID): self
    {
        $self = clone $this;
        $self['userID'] = $userID;

        return $self;
    }
}
