<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag\Bundles;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A named set of access that Claude can use in a Slack channel or a Slack workspace: connectors, repositories and credentials. Created and edited in claude.ai.
 *
 * @phpstan-type BetaClaudeTagBundleShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   description: string|null,
 *   displayName: string,
 *   type: 'bundle',
 *   updatedAt: \DateTimeInterface,
 * }
 */
final class BetaClaudeTagBundle implements BaseModel
{
    /** @use SdkModel<BetaClaudeTagBundleShape> */
    use SdkModel;

    /** @var 'bundle' $type */
    #[Required(type: new ConstantOf('bundle'))]
    public string $type = 'bundle';

    /**
     * The Bundle's identifier. Starts with `capp_`.
     */
    #[Required]
    public string $id;

    /**
     * Time the Bundle was created.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * What the Bundle is for. Null when it has none. Read-only.
     */
    #[Required]
    public ?string $description;

    /**
     * The Bundle's name. Always set. Read-only.
     */
    #[Required('display_name')]
    public string $displayName;

    /**
     * Time of the last change to the Bundle.
     */
    #[Required('updated_at')]
    public \DateTimeInterface $updatedAt;

    /**
     * `new BetaClaudeTagBundle()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaClaudeTagBundle::with(
     *   id: ..., createdAt: ..., description: ..., displayName: ..., updatedAt: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaClaudeTagBundle())
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withDescription(...)
     *   ->withDisplayName(...)
     *   ->withUpdatedAt(...)
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
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        ?string $description,
        string $displayName,
        \DateTimeInterface $updatedAt,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['description'] = $description;
        $self['displayName'] = $displayName;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * The Bundle's identifier. Starts with `capp_`.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Time the Bundle was created.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * What the Bundle is for. Null when it has none. Read-only.
     */
    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * The Bundle's name. Always set. Read-only.
     */
    public function withDisplayName(string $displayName): self
    {
        $self = clone $this;
        $self['displayName'] = $displayName;

        return $self;
    }

    /**
     * @param 'bundle' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Time of the last change to the Bundle.
     */
    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
