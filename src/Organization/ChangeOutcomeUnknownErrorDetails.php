<?php

declare(strict_types=1);

namespace Anthropic\Organization;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Some of the request's changes may have been saved and others not. Send the same request again to finish it; changes already saved aren't repeated.
 *
 * @phpstan-type ChangeOutcomeUnknownErrorDetailsShape = array{
 *   errorCode: 'change_outcome_unknown'
 * }
 */
final class ChangeOutcomeUnknownErrorDetails implements BaseModel
{
    /** @use SdkModel<ChangeOutcomeUnknownErrorDetailsShape> */
    use SdkModel;

    /** @var 'change_outcome_unknown' $errorCode */
    #[Required('error_code', type: new ConstantOf('change_outcome_unknown'))]
    public string $errorCode = 'change_outcome_unknown';

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
     * @param 'change_outcome_unknown' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
