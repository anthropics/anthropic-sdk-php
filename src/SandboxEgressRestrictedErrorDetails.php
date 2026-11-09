<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The request came from a Claude sandbox with restricted network access, which is not allowed to make this change. Send it from outside the sandbox, or from a sandbox with unrestricted network access.
 *
 * @phpstan-type SandboxEgressRestrictedErrorDetailsShape = array{
 *   errorCode: 'sandbox_egress_restricted'
 * }
 */
final class SandboxEgressRestrictedErrorDetails implements BaseModel
{
    /** @use SdkModel<SandboxEgressRestrictedErrorDetailsShape> */
    use SdkModel;

    /** @var 'sandbox_egress_restricted' $errorCode */
    #[Required('error_code', type: new ConstantOf('sandbox_egress_restricted'))]
    public string $errorCode = 'sandbox_egress_restricted';

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
     * @param 'sandbox_egress_restricted' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
