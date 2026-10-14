<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The Anthropic-managed service account as returned in API responses.
 *
 * @phpstan-type BetaManagedAgentsServiceAccountExecutionIdentityShape = array{
 *   type: 'service_account'
 * }
 */
final class BetaManagedAgentsServiceAccountExecutionIdentity implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsServiceAccountExecutionIdentityShape> */
    use SdkModel;

    /** @var 'service_account' $type */
    #[Required(type: new ConstantOf('service_account'))]
    public string $type = 'service_account';

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
     * @param 'service_account' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
