<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments;

use Anthropic\Beta\Deployments\BetaManagedAgentsGitHubRepositoryResourceConfig\Checkout;
use Anthropic\Beta\Deployments\BetaManagedAgentsGitHubRepositoryResourceConfig\Type;
use Anthropic\Beta\Sessions\BetaManagedAgentsBranchCheckout;
use Anthropic\Beta\Sessions\BetaManagedAgentsCommitCheckout;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A GitHub repository mounted into each session's container. The authorization token is write-only and never returned.
 *
 * @phpstan-import-type CheckoutVariants from \Anthropic\Beta\Deployments\BetaManagedAgentsGitHubRepositoryResourceConfig\Checkout
 * @phpstan-import-type CheckoutShape from \Anthropic\Beta\Deployments\BetaManagedAgentsGitHubRepositoryResourceConfig\Checkout
 *
 * @phpstan-type BetaManagedAgentsGitHubRepositoryResourceConfigShape = array{
 *   type: Type|value-of<Type>,
 *   url: string,
 *   checkout?: CheckoutShape|null,
 *   mountPath?: string|null,
 * }
 */
final class BetaManagedAgentsGitHubRepositoryResourceConfig implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsGitHubRepositoryResourceConfigShape> */
    use SdkModel;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * Github URL of the repository.
     */
    #[Required]
    public string $url;

    /**
     * Branch or commit to check out. Defaults to the repository's default branch.
     *
     * @var CheckoutVariants|null $checkout
     */
    #[Optional(union: Checkout::class, nullable: true)]
    public BetaManagedAgentsBranchCheckout|BetaManagedAgentsCommitCheckout|null $checkout;

    /**
     * Mount path in the container. Defaults to `/workspace/<repo-name>`.
     */
    #[Optional('mount_path', nullable: true)]
    public ?string $mountPath;

    /**
     * `new BetaManagedAgentsGitHubRepositoryResourceConfig()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsGitHubRepositoryResourceConfig::with(type: ..., url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsGitHubRepositoryResourceConfig)
     *   ->withType(...)
     *   ->withURL(...)
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
     * @param CheckoutShape|null $checkout
     */
    public static function with(
        Type|string $type,
        string $url,
        BetaManagedAgentsBranchCheckout|array|BetaManagedAgentsCommitCheckout|null $checkout = null,
        ?string $mountPath = null,
    ): self {
        $self = new self;

        $self['type'] = $type;
        $self['url'] = $url;

        null !== $checkout && $self['checkout'] = $checkout;
        null !== $mountPath && $self['mountPath'] = $mountPath;

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

    /**
     * Github URL of the repository.
     */
    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    /**
     * Branch or commit to check out. Defaults to the repository's default branch.
     *
     * @param CheckoutShape|null $checkout
     */
    public function withCheckout(
        BetaManagedAgentsBranchCheckout|array|BetaManagedAgentsCommitCheckout|null $checkout,
    ): self {
        $self = clone $this;
        $self['checkout'] = $checkout;

        return $self;
    }

    /**
     * Mount path in the container. Defaults to `/workspace/<repo-name>`.
     */
    public function withMountPath(?string $mountPath): self
    {
        $self = clone $this;
        $self['mountPath'] = $mountPath;

        return $self;
    }
}
