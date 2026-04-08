<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Sessions\SessionCreateParams\Resource;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Create Session.
 *
 * @see Anthropic\Services\Beta\SessionsService::create()
 *
 * @phpstan-import-type AgentVariants from \Anthropic\Beta\Sessions\SessionCreateParams\Agent
 * @phpstan-import-type ResourceVariants from \Anthropic\Beta\Sessions\SessionCreateParams\Resource
 * @phpstan-import-type AgentShape from \Anthropic\Beta\Sessions\SessionCreateParams\Agent
 * @phpstan-import-type ResourceShape from \Anthropic\Beta\Sessions\SessionCreateParams\Resource
 *
 * @phpstan-type SessionCreateParamsShape = array{
 *   agent: AgentShape,
 *   environmentID: string,
 *   metadata?: array<string,string>|null,
 *   resources?: list<ResourceShape>|null,
 *   title?: string|null,
 *   vaultIDs?: list<string>|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class SessionCreateParams implements BaseModel
{
    /** @use SdkModel<SessionCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Agent identifier. Accepts the `agent` ID string, which pins the latest version for the session, or an `agent` object with both id and version specified.
     *
     * @var AgentVariants $agent
     */
    #[Required]
    public string|BetaManagedAgentsAgentParams $agent;

    /**
     * ID of the `environment` defining the container configuration for this session.
     */
    #[Required('environment_id')]
    public string $environmentID;

    /**
     * Arbitrary key-value metadata attached to the session. Maximum 16 pairs, keys up to 64 chars, values up to 512 chars.
     *
     * @var array<string,string>|null $metadata
     */
    #[Optional(map: 'string')]
    public ?array $metadata;

    /**
     * Resources (e.g. repositories, files) to mount into the session's container.
     *
     * @var list<ResourceVariants>|null $resources
     */
    #[Optional(list: Resource::class)]
    public ?array $resources;

    /**
     * Human-readable session title.
     */
    #[Optional(nullable: true)]
    public ?string $title;

    /**
     * Vault IDs for stored credentials the agent can use during the session.
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

    /**
     * `new SessionCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SessionCreateParams::with(agent: ..., environmentID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SessionCreateParams)->withAgent(...)->withEnvironmentID(...)
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
     * @param AgentShape $agent
     * @param array<string,string>|null $metadata
     * @param list<ResourceShape>|null $resources
     * @param list<string>|null $vaultIDs
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        string|BetaManagedAgentsAgentParams|array $agent,
        string $environmentID,
        ?array $metadata = null,
        ?array $resources = null,
        ?string $title = null,
        ?array $vaultIDs = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        $self['agent'] = $agent;
        $self['environmentID'] = $environmentID;

        null !== $metadata && $self['metadata'] = $metadata;
        null !== $resources && $self['resources'] = $resources;
        null !== $title && $self['title'] = $title;
        null !== $vaultIDs && $self['vaultIDs'] = $vaultIDs;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Agent identifier. Accepts the `agent` ID string, which pins the latest version for the session, or an `agent` object with both id and version specified.
     *
     * @param AgentShape $agent
     */
    public function withAgent(
        string|BetaManagedAgentsAgentParams|array $agent
    ): self {
        $self = clone $this;
        $self['agent'] = $agent;

        return $self;
    }

    /**
     * ID of the `environment` defining the container configuration for this session.
     */
    public function withEnvironmentID(string $environmentID): self
    {
        $self = clone $this;
        $self['environmentID'] = $environmentID;

        return $self;
    }

    /**
     * Arbitrary key-value metadata attached to the session. Maximum 16 pairs, keys up to 64 chars, values up to 512 chars.
     *
     * @param array<string,string> $metadata
     */
    public function withMetadata(array $metadata): self
    {
        $self = clone $this;
        $self['metadata'] = $metadata;

        return $self;
    }

    /**
     * Resources (e.g. repositories, files) to mount into the session's container.
     *
     * @param list<ResourceShape> $resources
     */
    public function withResources(array $resources): self
    {
        $self = clone $this;
        $self['resources'] = $resources;

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
     * Vault IDs for stored credentials the agent can use during the session.
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
