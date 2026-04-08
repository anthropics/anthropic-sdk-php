<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Beta\Sessions\BetaManagedAgentsGitHubRepositoryResourceParams\Checkout;
use Anthropic\Beta\Sessions\BetaManagedAgentsGitHubRepositoryResourceParams\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Mount a GitHub repository into the session's container.
 *
 * @phpstan-import-type CheckoutVariants from \Anthropic\Beta\Sessions\BetaManagedAgentsGitHubRepositoryResourceParams\Checkout
 * @phpstan-import-type CheckoutShape from \Anthropic\Beta\Sessions\BetaManagedAgentsGitHubRepositoryResourceParams\Checkout
 *
 * @phpstan-type BetaManagedAgentsGitHubRepositoryResourceParamsShape = array{
 *   authorizationToken: string,
 *   type: Type|value-of<Type>,
 *   url: string,
 *   checkout?: CheckoutShape|null,
 *   mountPath?: string|null,
 * }
 */
final class BetaManagedAgentsGitHubRepositoryResourceParams implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsGitHubRepositoryResourceParamsShape> */
    use SdkModel;

    /**
     * GitHub authorization token used to clone the repository.
     */
    #[Required('authorization_token')]
    public string $authorizationToken;

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
     * `new BetaManagedAgentsGitHubRepositoryResourceParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsGitHubRepositoryResourceParams::with(
     *   authorizationToken: ..., type: ..., url: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsGitHubRepositoryResourceParams)
     *   ->withAuthorizationToken(...)
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
        string $authorizationToken,
        Type|string $type,
        string $url,
        BetaManagedAgentsBranchCheckout|array|BetaManagedAgentsCommitCheckout|null $checkout = null,
        ?string $mountPath = null,
    ): self {
        $self = new self;

        $self['authorizationToken'] = $authorizationToken;
        $self['type'] = $type;
        $self['url'] = $url;

        null !== $checkout && $self['checkout'] = $checkout;
        null !== $mountPath && $self['mountPath'] = $mountPath;

        return $self;
    }

    /**
     * GitHub authorization token used to clone the repository.
     */
    public function withAuthorizationToken(string $authorizationToken): self
    {
        $self = clone $this;
        $self['authorizationToken'] = $authorizationToken;

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
