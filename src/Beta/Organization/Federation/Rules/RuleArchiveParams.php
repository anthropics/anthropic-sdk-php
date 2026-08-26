<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Federation\Rules;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
 *
 * Archive a federation rule.
 *
 * Token exchange through this rule stops immediately. Idempotent;
 * re-archiving returns the rule with its original `archived_at`. Archiving
 * clears the rule's workspace targeting (`workspace_id` and
 * `workspace_ids` are emptied). Tokens already minted before archive
 * remain valid until they expire. OAuth callers may only manage rules
 * whose `oauth_scope` is `workspace:developer` or `workspace:inference`;
 * other scopes require a Console session.
 *
 * @see Anthropic\Services\Beta\Organization\Federation\RulesService::archive()
 *
 * @phpstan-type RuleArchiveParamsShape = array{
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null
 * }
 */
final class RuleArchiveParams implements BaseModel
{
    /** @use SdkModel<RuleArchiveParamsShape> */
    use SdkModel;
    use SdkParams;

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
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(?array $betas = null): self
    {
        $self = new self;

        null !== $betas && $self['betas'] = $betas;

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
