<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The key management service's network access controls blocked the request to the workspace's customer-managed encryption key. The key itself may be healthy.
 *
 * @phpstan-type CMEKKeyNetworkBlockedErrorDetailsShape = array{
 *   errorCode: 'cmek_key_network_blocked'
 * }
 */
final class CMEKKeyNetworkBlockedErrorDetails implements BaseModel
{
    /** @use SdkModel<CMEKKeyNetworkBlockedErrorDetailsShape> */
    use SdkModel;

    /** @var 'cmek_key_network_blocked' $errorCode */
    #[Required('error_code', type: new ConstantOf('cmek_key_network_blocked'))]
    public string $errorCode = 'cmek_key_network_blocked';

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
     * @param 'cmek_key_network_blocked' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
