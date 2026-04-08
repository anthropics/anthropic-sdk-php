<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Unrestricted network access.
 *
 * @phpstan-type BetaUnrestrictedNetworkShape = array{type: 'unrestricted'}
 */
final class BetaUnrestrictedNetwork implements BaseModel
{
    /** @use SdkModel<BetaUnrestrictedNetworkShape> */
    use SdkModel;

    /**
     * Network policy type.
     *
     * @var 'unrestricted' $type
     */
    #[Required]
    public string $type = 'unrestricted';

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
     * Network policy type.
     *
     * @param 'unrestricted' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
