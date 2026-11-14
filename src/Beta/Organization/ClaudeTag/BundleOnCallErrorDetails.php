<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * This Bundle's instructions are managed in claude.ai and can't be changed through the API.
 *
 * @phpstan-type BundleOnCallErrorDetailsShape = array{errorCode: 'bundle_on_call'}
 */
final class BundleOnCallErrorDetails implements BaseModel
{
    /** @use SdkModel<BundleOnCallErrorDetailsShape> */
    use SdkModel;

    /** @var 'bundle_on_call' $errorCode */
    #[Required('error_code', type: new ConstantOf('bundle_on_call'))]
    public string $errorCode = 'bundle_on_call';

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
     * @param 'bundle_on_call' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
