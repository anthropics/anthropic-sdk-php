<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\MapOf;

/**
 * Update Session.
 *
 * @see Anthropic\Services\Beta\SessionsService::update()
 *
 * @phpstan-type SessionUpdateParamsShape = array{
 *   metadata?: array<string,string|null>|null,
 *   title?: string|null,
 *   vaultIDs?: list<string>|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class SessionUpdateParams implements BaseModel
{
    /** @use SdkModel<SessionUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Metadata patch. Set a key to a string to upsert it, or to null to delete it. Omit the field to preserve.
     *
     * @var array<string,string|null>|null $metadata
     */
    #[Optional(type: new MapOf('string', nullable: true), nullable: true)]
    public ?array $metadata;

    /**
     * Human-readable session title.
     */
    #[Optional(nullable: true)]
    public ?string $title;

    /**
     * Vault IDs (`vlt_*`) to attach to the session. Not yet supported; requests setting this field are rejected. Reserved for future use.
     *
     * @var list<string>|null $vaultIDs
     */
    #[Optional('vault_ids', list: 'string')]
    public ?array $vaultIDs;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param array<string,string|null>|null $metadata
     * @param list<string>|null $vaultIDs
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        ?array $metadata = null,
        ?string $title = null,
        ?array $vaultIDs = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        null !== $metadata && $self['metadata'] = $metadata;
        null !== $title && $self['title'] = $title;
        null !== $vaultIDs && $self['vaultIDs'] = $vaultIDs;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Metadata patch. Set a key to a string to upsert it, or to null to delete it. Omit the field to preserve.
     *
     * @param array<string,string|null>|null $metadata
     */
    public function withMetadata(?array $metadata): self
    {
        $self = clone $this;
        $self['metadata'] = $metadata;

        return $self;
    }

    /**
     * Human-readable session title.
     */
    public function withTitle(?string $title): self
    {
        $self = clone $this;
        $self['title'] = $title;

        return $self;
    }

    /**
     * Vault IDs (`vlt_*`) to attach to the session. Not yet supported; requests setting this field are rejected. Reserved for future use.
     *
     * @param list<string> $vaultIDs
     */
    public function withVaultIDs(array $vaultIDs): self
    {
        $self = clone $this;
        $self['vaultIDs'] = $vaultIDs;

        return $self;
    }

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas
     */
    public function withBetas(array $betas): self
    {
        $self = clone $this;
        $self['betas'] = $betas;

        return $self;
    }
}
