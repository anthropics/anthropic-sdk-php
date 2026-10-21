<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Beta\Sessions\BetaManagedAgentsGitHubRepositoryResourceParams\Checkout;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Mount a GitHub repository into the session's container.
 *
 * @phpstan-import-type CheckoutShape from \Anthropic\Beta\Sessions\BetaManagedAgentsGitHubRepositoryResourceParams\Checkout
 * @phpstan-import-type CheckoutVariants from \Anthropic\Beta\Sessions\BetaManagedAgentsGitHubRepositoryResourceParams\Checkout
 *
 * @phpstan-type BetaManagedAgentsGitHubRepositoryResourceParamsShape = array{
 *   type: 'github_repository',
 *   url: string,
 *   authorizationToken?: string|null,
 *   checkout?: CheckoutShape|null,
 *   mountPath?: string|null,
 * }
 */
final class BetaManagedAgentsGitHubRepositoryResourceParams implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsGitHubRepositoryResourceParamsShape> */
    use SdkModel;

    /** @var 'github_repository' $type */
    #[Required(type: new ConstantOf('github_repository'))]
    public string $type = 'github_repository';

    /**
     * Github URL of the repository.
     */
    #[Required]
    public string $url;

    /**
     * GitHub authorization token used to clone the repository. Required for private repositories; optional for public ones.
     */
    #[Optional('authorization_token')]
    public ?string $authorizationToken;

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
     * BetaManagedAgentsGitHubRepositoryResourceParams::with(url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsGitHubRepositoryResourceParams())->withURL(...)
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
     * @param CheckoutShape|null $checkout
     */
    public static function with(
        string $url,
        ?string $authorizationToken = null,
        BetaManagedAgentsBranchCheckout|array|BetaManagedAgentsCommitCheckout|null $checkout = null,
        ?string $mountPath = null,
    ): self {
        $self = new self;

        $self['url'] = $url;

        null !== $authorizationToken && $self['authorizationToken'] = $authorizationToken;
        null !== $checkout && $self['checkout'] = $checkout;
        null !== $mountPath && $self['mountPath'] = $mountPath;

        return $self;
    }

    /**
     * @param 'github_repository' $type
     */
    public function withType(string $type): self
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
     * GitHub authorization token used to clone the repository. Required for private repositories; optional for public ones.
     */
    public function withAuthorizationToken(string $authorizationToken): self
    {
        $self = clone $this;
        $self['authorizationToken'] = $authorizationToken;

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
