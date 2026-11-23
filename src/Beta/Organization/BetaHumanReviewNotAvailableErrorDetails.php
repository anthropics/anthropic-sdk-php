<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Human review can't be set as requested on this Workspace, so the request changed nothing. The error's `message` says what to do instead.
 *
 * @phpstan-type BetaHumanReviewNotAvailableErrorDetailsShape = array{
 *   errorCode: 'human_review_not_available'
 * }
 */
final class BetaHumanReviewNotAvailableErrorDetails implements BaseModel
{
    /** @use SdkModel<BetaHumanReviewNotAvailableErrorDetailsShape> */
    use SdkModel;

    /** @var 'human_review_not_available' $errorCode */
    #[Required('error_code', type: new ConstantOf('human_review_not_available'))]
    public string $errorCode = 'human_review_not_available';

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
     * @param 'human_review_not_available' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
