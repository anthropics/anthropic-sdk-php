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
 * @phpstan-import-type BetaManagedAgentsSessionAgentUpdateShape from \Anthropic\Beta\Sessions\BetaManagedAgentsSessionAgentUpdate
 * @phpstan-import-type BetaManagedAgentsBudgetLimitShape from \Anthropic\Beta\Sessions\BetaManagedAgentsBudgetLimit
 *
 * @phpstan-type SessionUpdateParamsShape = array{
 *   agent?: null|BetaManagedAgentsSessionAgentUpdate|BetaManagedAgentsSessionAgentUpdateShape,
 *   budget?: null|BetaManagedAgentsBudgetLimit|BetaManagedAgentsBudgetLimitShape,
 *   metadata?: array<string,string|null>|null,
 *   title?: string|null,
 *   vaultIDs?: list<string>|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 *   workspaceID?: string|null,
 * }
 */
final class SessionUpdateParams implements BaseModel
{
    /** @use SdkModel<SessionUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Agent configuration update. Only `tools` and `mcp_servers` are updatable mid-session. Only valid for sessions created from an agent or deployment reference. The session must not be running.
     */
    #[Optional]
    public ?BetaManagedAgentsSessionAgentUpdate $agent;

    /**
     * Enforced spend ceiling for the session. Set an object to replace the budget of a session that was created with one, or `null` to remove it; omit to preserve. A budget cannot be added to a session created without one (rejected with reason `budget_create_only`), and a removed budget cannot be re-added. Allowed in any non-terminated status. Lowering `max_list_cost` to at or below the session's consumed list cost is rejected with reason `budget_not_raised`, and every model the session can run must have a public list price or the request is rejected with reason `model_not_budgetable`.
     */
    #[Optional(nullable: true)]
    public ?BetaManagedAgentsBudgetLimit $budget;

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

    /**
     * Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     */
    #[Optional]
    public ?string $workspaceID;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param BetaManagedAgentsSessionAgentUpdate|BetaManagedAgentsSessionAgentUpdateShape|null $agent
     * @param BetaManagedAgentsBudgetLimit|BetaManagedAgentsBudgetLimitShape|null $budget
     * @param array<string,string|null>|null $metadata
     * @param list<string>|null $vaultIDs
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        BetaManagedAgentsSessionAgentUpdate|array|null $agent = null,
        BetaManagedAgentsBudgetLimit|array|null $budget = null,
        ?array $metadata = null,
        ?string $title = null,
        ?array $vaultIDs = null,
        ?array $betas = null,
        ?string $workspaceID = null,
    ): self {
        $self = new self;

        null !== $agent && $self['agent'] = $agent;
        null !== $budget && $self['budget'] = $budget;
        null !== $metadata && $self['metadata'] = $metadata;
        null !== $title && $self['title'] = $title;
        null !== $vaultIDs && $self['vaultIDs'] = $vaultIDs;
        null !== $betas && $self['betas'] = $betas;
        null !== $workspaceID && $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * Agent configuration update. Only `tools` and `mcp_servers` are updatable mid-session. Only valid for sessions created from an agent or deployment reference. The session must not be running.
     *
     * @param BetaManagedAgentsSessionAgentUpdate|BetaManagedAgentsSessionAgentUpdateShape $agent
     */
    public function withAgent(
        BetaManagedAgentsSessionAgentUpdate|array $agent
    ): self {
        $self = clone $this;
        $self['agent'] = $agent;

        return $self;
    }

    /**
     * Enforced spend ceiling for the session. Set an object to replace the budget of a session that was created with one, or `null` to remove it; omit to preserve. A budget cannot be added to a session created without one (rejected with reason `budget_create_only`), and a removed budget cannot be re-added. Allowed in any non-terminated status. Lowering `max_list_cost` to at or below the session's consumed list cost is rejected with reason `budget_not_raised`, and every model the session can run must have a public list price or the request is rejected with reason `model_not_budgetable`.
     *
     * @param BetaManagedAgentsBudgetLimit|BetaManagedAgentsBudgetLimitShape|null $budget
     */
    public function withBudget(
        BetaManagedAgentsBudgetLimit|array|null $budget
    ): self {
        $self = clone $this;
        $self['budget'] = $budget;

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

    /**
     * Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     */
    public function withWorkspaceID(string $workspaceID): self
    {
        $self = clone $this;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }
}
