<?php

declare(strict_types=1);

namespace Anthropic\Organization\Invites;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The email address's domain is not one of the verified domains of the organization's parent organization.
 *
 * @phpstan-type CannotInviteEmailsWithUnverifiedDomainsErrorDetailsShape = array{
 *   errorCode: 'cannot_invite_emails_with_unverified_domains'
 * }
 */
final class CannotInviteEmailsWithUnverifiedDomainsErrorDetails implements BaseModel
{
    /** @use SdkModel<CannotInviteEmailsWithUnverifiedDomainsErrorDetailsShape> */
    use SdkModel;

    /** @var 'cannot_invite_emails_with_unverified_domains' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('cannot_invite_emails_with_unverified_domains'),
    )]
    public string $errorCode = 'cannot_invite_emails_with_unverified_domains';

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
     * @param 'cannot_invite_emails_with_unverified_domains' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
