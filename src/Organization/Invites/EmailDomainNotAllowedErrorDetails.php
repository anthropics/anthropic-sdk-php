<?php

declare(strict_types=1);

namespace Anthropic\Organization\Invites;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The organization restricts invites to an allowed list of email domains, and the list is empty or does not include the email address's domain.
 *
 * @phpstan-type EmailDomainNotAllowedErrorDetailsShape = array{
 *   errorCode: 'email_domain_not_allowed'
 * }
 */
final class EmailDomainNotAllowedErrorDetails implements BaseModel
{
    /** @use SdkModel<EmailDomainNotAllowedErrorDetailsShape> */
    use SdkModel;

    /** @var 'email_domain_not_allowed' $errorCode */
    #[Required('error_code', type: new ConstantOf('email_domain_not_allowed'))]
    public string $errorCode = 'email_domain_not_allowed';

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
     * @param 'email_domain_not_allowed' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
