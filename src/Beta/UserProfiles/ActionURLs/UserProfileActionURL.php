<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\ActionURLs;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A URL to give to the person who takes the requested action.
 *
 * @phpstan-type UserProfileActionURLShape = array{
 *   expiresAt: \DateTimeInterface, type: 'user_profile_action_url', url: string
 * }
 */
final class UserProfileActionURL implements BaseModel
{
    /** @use SdkModel<UserProfileActionURLShape> */
    use SdkModel;

    /**
     * Object type. Always `user_profile_action_url`.
     *
     * @var 'user_profile_action_url' $type
     */
    #[Required(type: new ConstantOf('user_profile_action_url'))]
    public string $type = 'user_profile_action_url';

    /**
     * When the URL stops working, in RFC 3339 format.
     */
    #[Required('expires_at')]
    public \DateTimeInterface $expiresAt;

    /**
     * The URL to give to the person who takes the action. Anyone who holds it can open it until `expires_at`.
     */
    #[Required]
    public string $url;

    /**
     * `new UserProfileActionURL()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * UserProfileActionURL::with(expiresAt: ..., url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new UserProfileActionURL())->withExpiresAt(...)->withURL(...)
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
    public static function with(
        \DateTimeInterface $expiresAt,
        string $url
    ): self {
        $self = new self;

        $self['expiresAt'] = $expiresAt;
        $self['url'] = $url;

        return $self;
    }

    /**
     * When the URL stops working, in RFC 3339 format.
     */
    public function withExpiresAt(\DateTimeInterface $expiresAt): self
    {
        $self = clone $this;
        $self['expiresAt'] = $expiresAt;

        return $self;
    }

    /**
     * Object type. Always `user_profile_action_url`.
     *
     * @param 'user_profile_action_url' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * The URL to give to the person who takes the action. Anyone who holds it can open it until `expires_at`.
     */
    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
