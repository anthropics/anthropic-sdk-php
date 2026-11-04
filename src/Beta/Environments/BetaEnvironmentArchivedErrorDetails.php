<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The environment is archived, so it cannot be updated.
 *
 * @phpstan-type BetaEnvironmentArchivedErrorDetailsShape = array{
 *   errorCode: 'environment_archived'
 * }
 */
final class BetaEnvironmentArchivedErrorDetails implements BaseModel
{
    /** @use SdkModel<BetaEnvironmentArchivedErrorDetailsShape> */
    use SdkModel;

    /** @var 'environment_archived' $errorCode */
    #[Required('error_code', type: new ConstantOf('environment_archived'))]
    public string $errorCode = 'environment_archived';

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
     * @param 'environment_archived' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
