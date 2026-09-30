<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A user in the organization, identified by tagged id and email address.
 *
 * @phpstan-type AnalyticsUserShape = array{
 *   id: string, emailAddress: string, type: 'user'
 * }
 */
final class AnalyticsUser implements BaseModel
{
    /** @use SdkModel<AnalyticsUserShape> */
    use SdkModel;

    /**
     * Object type. Always `user`.
     *
     * @var 'user' $type
     */
    #[Required(type: new ConstantOf('user'))]
    public string $type = 'user';

    /**
     * Tagged user identifier (e.g. `user_...`).
     */
    #[Required]
    public string $id;

    /**
     * Email address of the user.
     */
    #[Required('email_address')]
    public string $emailAddress;

    /**
     * `new AnalyticsUser()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsUser::with(id: ..., emailAddress: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsUser)->withID(...)->withEmailAddress(...)
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
    public static function with(string $id, string $emailAddress): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['emailAddress'] = $emailAddress;

        return $self;
    }

    /**
     * Tagged user identifier (e.g. `user_...`).
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Email address of the user.
     */
    public function withEmailAddress(string $emailAddress): self
    {
        $self = clone $this;
        $self['emailAddress'] = $emailAddress;

        return $self;
    }

    /**
     * Object type. Always `user`.
     *
     * @param 'user' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
