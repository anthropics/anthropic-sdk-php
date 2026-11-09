<?php

declare(strict_types=1);

namespace Anthropic\Organization\ExternalKeys;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The External Key can't be deleted or reconfigured while the organization's Workspace Policy lists it as an allowed key.
 *
 * @phpstan-type ExternalKeyInWorkspacePolicyErrorDetailsShape = array{
 *   errorCode: 'external_key_in_workspace_policy'
 * }
 */
final class ExternalKeyInWorkspacePolicyErrorDetails implements BaseModel
{
    /** @use SdkModel<ExternalKeyInWorkspacePolicyErrorDetailsShape> */
    use SdkModel;

    /** @var 'external_key_in_workspace_policy' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('external_key_in_workspace_policy')
    )]
    public string $errorCode = 'external_key_in_workspace_policy';

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
     * @param 'external_key_in_workspace_policy' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
