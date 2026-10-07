<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type PluginOwnerUserShape = array{type: 'user', userID: string}
 */
final class PluginOwnerUser implements BaseModel
{
    /** @use SdkModel<PluginOwnerUserShape> */
    use SdkModel;

    /**
     * The Plugin lives in one member's personal plugin marketplace.
     *
     * @var 'user' $type
     */
    #[Required(type: new ConstantOf('user'))]
    public string $type = 'user';

    /**
     * The member's User ID.
     */
    #[Required('user_id')]
    public string $userID;

    /**
     * `new PluginOwnerUser()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PluginOwnerUser::with(userID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PluginOwnerUser())->withUserID(...)
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
     * The Plugin lives in one member's personal plugin marketplace.
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
     * The member's User ID.
     */
    public function withUserID(string $userID): self
    {
        $self = clone $this;
        $self['userID'] = $userID;

        return $self;
    }
}
