<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\ActionURLs;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The end-user that the profile represents enrolls in a program.
 *
 * @phpstan-type UserProfileEnrollEndUserActionShape = array{
 *   type: 'enroll_end_user'
 * }
 */
final class UserProfileEnrollEndUserAction implements BaseModel
{
    /** @use SdkModel<UserProfileEnrollEndUserActionShape> */
    use SdkModel;

    /** @var 'enroll_end_user' $type */
    #[Required(type: new ConstantOf('enroll_end_user'))]
    public string $type = 'enroll_end_user';

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
     * @param 'enroll_end_user' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
