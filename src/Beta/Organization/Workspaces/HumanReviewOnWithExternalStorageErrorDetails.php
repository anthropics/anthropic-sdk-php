<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The request would leave the Workspace with `inference_data_privacy.safeguards_storage` set to External Storage and `inference_data_privacy.human_review` enabled. Anthropic doesn't offer human review of data in a customer's own storage. Set `human_review` to `disabled`, or `safeguards_storage` to `internal`.
 *
 * @phpstan-type HumanReviewOnWithExternalStorageErrorDetailsShape = array{
 *   errorCode: 'human_review_on_with_external_storage'
 * }
 */
final class HumanReviewOnWithExternalStorageErrorDetails implements BaseModel
{
    /** @use SdkModel<HumanReviewOnWithExternalStorageErrorDetailsShape> */
    use SdkModel;

    /** @var 'human_review_on_with_external_storage' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('human_review_on_with_external_storage')
    )]
    public string $errorCode = 'human_review_on_with_external_storage';

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
     * @param 'human_review_on_with_external_storage' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
