<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Beta\Sessions\BetaManagedAgentsCommitCheckout\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaManagedAgentsCommitCheckoutShape = array{
 *   sha: string, type: Type|value-of<Type>
 * }
 */
final class BetaManagedAgentsCommitCheckout implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsCommitCheckoutShape> */
    use SdkModel;

    /**
     * Full commit SHA to check out.
     */
    #[Required]
    public string $sha;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new BetaManagedAgentsCommitCheckout()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsCommitCheckout::with(sha: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsCommitCheckout)->withSha(...)->withType(...)
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
     *
     * @param Type|value-of<Type> $type
     */
    public static function with(string $sha, Type|string $type): self
    {
        $self = new self;

        $self['sha'] = $sha;
        $self['type'] = $type;

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
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
