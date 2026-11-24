<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Anthropic has not approved customer-managed encryption keys for the organization, project or user profile this request applies to, or has paused or withdrawn its approval. If you did not expect this, contact Anthropic.
 *
 * @phpstan-type BetaCMEKNotApprovedErrorDetailsShape = array{
 *   errorCode: 'cmek_not_approved'
 * }
 */
final class BetaCMEKNotApprovedErrorDetails implements BaseModel
{
    /** @use SdkModel<BetaCMEKNotApprovedErrorDetailsShape> */
    use SdkModel;

    /** @var 'cmek_not_approved' $errorCode */
    #[Required('error_code', type: new ConstantOf('cmek_not_approved'))]
    public string $errorCode = 'cmek_not_approved';

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
     * @param 'cmek_not_approved' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
