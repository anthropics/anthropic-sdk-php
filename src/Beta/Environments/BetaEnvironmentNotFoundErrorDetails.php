<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * `settings.environment_id` names no Environment within the organization's reach.
 *
 * @phpstan-type BetaEnvironmentNotFoundErrorDetailsShape = array{
 *   errorCode: 'environment_not_found'
 * }
 */
final class BetaEnvironmentNotFoundErrorDetails implements BaseModel
{
    /** @use SdkModel<BetaEnvironmentNotFoundErrorDetailsShape> */
    use SdkModel;

    /** @var 'environment_not_found' $errorCode */
    #[Required('error_code', type: new ConstantOf('environment_not_found'))]
    public string $errorCode = 'environment_not_found';

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
     * @param 'environment_not_found' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
