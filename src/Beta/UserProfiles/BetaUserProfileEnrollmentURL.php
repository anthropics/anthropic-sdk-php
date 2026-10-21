<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A URL to give to the entity that a user profile represents, so that the entity can enroll in a program.
 *
 * @phpstan-type BetaUserProfileEnrollmentURLShape = array{
 *   expiresAt: \DateTimeInterface, type: 'enrollment_url', url: string
 * }
 */
final class BetaUserProfileEnrollmentURL implements BaseModel
{
    /** @use SdkModel<BetaUserProfileEnrollmentURLShape> */
    use SdkModel;

    /**
     * Object type. Always `enrollment_url`.
     *
     * @var 'enrollment_url' $type
     */
    #[Required(type: new ConstantOf('enrollment_url'))]
    public string $type = 'enrollment_url';

    /**
     * When this enrollment URL expires, in RFC 3339 format.
     */
    #[Required('expires_at')]
    public \DateTimeInterface $expiresAt;

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
     * BetaUserProfileEnrollmentURL::with(expiresAt: ..., url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaUserProfileEnrollmentURL())->withExpiresAt(...)->withURL(...)
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
     * When this enrollment URL expires, in RFC 3339 format.
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
     * @param 'enrollment_url' $type
     */
    public function withType(string $type): self
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
