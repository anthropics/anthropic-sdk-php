<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Configuration for self-hosted environments.
 *
 * @phpstan-type BetaSelfHostedConfigShape = array{type: 'self_hosted'}
 */
final class BetaSelfHostedConfig implements BaseModel
{
    /** @use SdkModel<BetaSelfHostedConfigShape> */
    use SdkModel;

    /**
     * Environment type.
     *
     * @var 'self_hosted' $type
     */
    #[Required]
    public string $type = 'self_hosted';

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
     * Environment type.
     *
     * @param 'self_hosted' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
