<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The Bundle has an attachment this API does not support editing, so its instructions can be changed only in claude.ai.
 *
 * @phpstan-type BundleAttachmentNotSupportedErrorDetailsShape = array{
 *   errorCode: 'bundle_attachment_not_supported'
 * }
 */
final class BundleAttachmentNotSupportedErrorDetails implements BaseModel
{
    /** @use SdkModel<BundleAttachmentNotSupportedErrorDetailsShape> */
    use SdkModel;

    /** @var 'bundle_attachment_not_supported' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('bundle_attachment_not_supported')
    )]
    public string $errorCode = 'bundle_attachment_not_supported';

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
     * @param 'bundle_attachment_not_supported' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
