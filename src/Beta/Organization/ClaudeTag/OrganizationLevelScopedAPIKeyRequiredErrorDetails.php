<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The credential is not a scoped API key that is bound at the organization level.
 *
 * @phpstan-type OrganizationLevelScopedAPIKeyRequiredErrorDetailsShape = array{
 *   errorCode: 'organization_level_scoped_api_key_required'
 * }
 */
final class OrganizationLevelScopedAPIKeyRequiredErrorDetails implements BaseModel
{
    /** @use SdkModel<OrganizationLevelScopedAPIKeyRequiredErrorDetailsShape> */
    use SdkModel;

    /** @var 'organization_level_scoped_api_key_required' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('organization_level_scoped_api_key_required'),
    )]
    public string $errorCode = 'organization_level_scoped_api_key_required';

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
     * @param 'organization_level_scoped_api_key_required' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
