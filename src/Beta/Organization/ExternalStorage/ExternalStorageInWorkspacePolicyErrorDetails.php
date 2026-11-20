<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The External Storage can't be deleted while an Enterprise Frontier Safeguards workspace policy lists it as allowed storage.
 *
 * @phpstan-type ExternalStorageInWorkspacePolicyErrorDetailsShape = array{
 *   errorCode: 'external_storage_in_workspace_policy'
 * }
 */
final class ExternalStorageInWorkspacePolicyErrorDetails implements BaseModel
{
    /** @use SdkModel<ExternalStorageInWorkspacePolicyErrorDetailsShape> */
    use SdkModel;

    /** @var 'external_storage_in_workspace_policy' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('external_storage_in_workspace_policy')
    )]
    public string $errorCode = 'external_storage_in_workspace_policy';

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
     * @param 'external_storage_in_workspace_policy' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
