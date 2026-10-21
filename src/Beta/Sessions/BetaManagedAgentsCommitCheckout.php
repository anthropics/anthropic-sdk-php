<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type BetaManagedAgentsCommitCheckoutShape = array{
 *   sha: string, type: 'commit'
 * }
 */
final class BetaManagedAgentsCommitCheckout implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsCommitCheckoutShape> */
    use SdkModel;

    /** @var 'commit' $type */
    #[Required(type: new ConstantOf('commit'))]
    public string $type = 'commit';

    /**
     * Full commit SHA to check out.
     */
    #[Required]
    public string $sha;

    /**
     * `new BetaManagedAgentsCommitCheckout()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsCommitCheckout::with(sha: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsCommitCheckout())->withSha(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(string $sha): self
    {
        $self = new self;

        $self['sha'] = $sha;

        return $self;
    }

    /**
     * Full commit SHA to check out.
     */
    public function withSha(string $sha): self
    {
        $self = clone $this;
        $self['sha'] = $sha;

        return $self;
    }

    /**
     * @param 'commit' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
