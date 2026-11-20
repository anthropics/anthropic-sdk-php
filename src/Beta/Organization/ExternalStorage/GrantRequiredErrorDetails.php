<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Anthropic has not approved External Storage for the organization, for the Workspace or, for storage bound to a user profile, for that user profile. Contact your Anthropic account team.
 *
 * @phpstan-type GrantRequiredErrorDetailsShape = array{
 *   errorCode: 'grant_required'
 * }
 */
final class GrantRequiredErrorDetails implements BaseModel
{
    /** @use SdkModel<GrantRequiredErrorDetailsShape> */
    use SdkModel;

    /** @var 'grant_required' $errorCode */
    #[Required('error_code', type: new ConstantOf('grant_required'))]
    public string $errorCode = 'grant_required';

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
     * @param 'grant_required' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
