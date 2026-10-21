<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Resources;

use Anthropic\Beta\Sessions\BetaManagedAgentsBranchCheckout;
use Anthropic\Beta\Sessions\BetaManagedAgentsCommitCheckout;
use Anthropic\Beta\Sessions\Resources\ManagedAgentsGitHubRepositoryResource\Checkout;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-import-type CheckoutShape from \Anthropic\Beta\Sessions\Resources\ManagedAgentsGitHubRepositoryResource\Checkout
 * @phpstan-import-type CheckoutVariants from \Anthropic\Beta\Sessions\Resources\ManagedAgentsGitHubRepositoryResource\Checkout
 *
 * @phpstan-type ManagedAgentsGitHubRepositoryResourceShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   mountPath: string,
 *   type: 'github_repository',
 *   updatedAt: \DateTimeInterface,
 *   url: string,
 *   checkout?: CheckoutShape|null,
 * }
 */
final class ManagedAgentsGitHubRepositoryResource implements BaseModel
{
    /** @use SdkModel<ManagedAgentsGitHubRepositoryResourceShape> */
    use SdkModel;

    /** @var 'github_repository' $type */
    #[Required(type: new ConstantOf('github_repository'))]
    public string $type = 'github_repository';

    #[Required]
    public string $id;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    #[Required('mount_path')]
    public string $mountPath;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('updated_at')]
    public \DateTimeInterface $updatedAt;

    #[Required]
    public string $url;

    /** @var CheckoutVariants|null $checkout */
    #[Optional(union: Checkout::class, nullable: true)]
    public BetaManagedAgentsBranchCheckout|BetaManagedAgentsCommitCheckout|null $checkout;

    /**
     * `new ManagedAgentsGitHubRepositoryResource()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsGitHubRepositoryResource::with(
     *   id: ..., createdAt: ..., mountPath: ..., updatedAt: ..., url: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsGitHubRepositoryResource())
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withMountPath(...)
     *   ->withUpdatedAt(...)
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
     * @param CheckoutShape|null $checkout
     */
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        string $mountPath,
        \DateTimeInterface $updatedAt,
        string $url,
        BetaManagedAgentsBranchCheckout|array|BetaManagedAgentsCommitCheckout|null $checkout = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['mountPath'] = $mountPath;
        $self['updatedAt'] = $updatedAt;
        $self['url'] = $url;

        null !== $checkout && $self['checkout'] = $checkout;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * A timestamp in RFC 3339 format.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    public function withMountPath(string $mountPath): self
    {
        $self = clone $this;
        $self['mountPath'] = $mountPath;

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
     * A timestamp in RFC 3339 format.
     */
    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    /**
     * @param CheckoutShape|null $checkout
     */
    public function withCheckout(
        BetaManagedAgentsBranchCheckout|array|BetaManagedAgentsCommitCheckout|null $checkout,
    ): self {
        $self = clone $this;
        $self['checkout'] = $checkout;

        return $self;
    }
}
