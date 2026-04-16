<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles;

use Anthropic\Beta\UserProfiles\BetaUserProfileEnrollmentURL\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaUserProfileEnrollmentURLShape = array{
 *   expiresAt: \DateTimeInterface, type: Type|value-of<Type>, url: string
 * }
 */
final class BetaUserProfileEnrollmentURL implements BaseModel
{
    /** @use SdkModel<BetaUserProfileEnrollmentURLShape> */
    use SdkModel;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('expires_at')]
    public \DateTimeInterface $expiresAt;

    /**
     * Object type. Always `enrollment_url`.
     *
     * @var value-of<Type> $type
     */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * Enrollment URL to send to the end user. Valid until `expires_at`.
     */
    #[Required]
    public string $url;

    /**
     * `new BetaUserProfileEnrollmentURL()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaUserProfileEnrollmentURL::with(expiresAt: ..., type: ..., url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaUserProfileEnrollmentURL)
     *   ->withExpiresAt(...)
     *   ->withType(...)
     *   ->withURL(...)
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
     *
     * @param Type|value-of<Type> $type
     */
    public static function with(
        \DateTimeInterface $expiresAt,
        Type|string $type,
        string $url
    ): self {
        $self = new self;

        $self['expiresAt'] = $expiresAt;
        $self['type'] = $type;
        $self['url'] = $url;

        return $self;
    }

    /**
     * A timestamp in RFC 3339 format.
     */
    public function withExpiresAt(\DateTimeInterface $expiresAt): self
    {
        $self = clone $this;
        $self['expiresAt'] = $expiresAt;

        return $self;
    }

    /**
     * Object type. Always `enrollment_url`.
     *
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Enrollment URL to send to the end user. Valid until `expires_at`.
     */
    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
