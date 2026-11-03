<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The tools available after a message exceed a limit on their number or their size.
 *
 * @phpstan-type AvailableToolsLimitExceededErrorDetailsShape = array{
 *   errorCode: 'available_tools_limit_exceeded'
 * }
 */
final class AvailableToolsLimitExceededErrorDetails implements BaseModel
{
    /** @use SdkModel<AvailableToolsLimitExceededErrorDetailsShape> */
    use SdkModel;

    /** @var 'available_tools_limit_exceeded' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('available_tools_limit_exceeded')
    )]
    public string $errorCode = 'available_tools_limit_exceeded';

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
     * @param 'available_tools_limit_exceeded' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
