<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\SpendLimits;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitSetParams\Scope;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Set a spend limit.
 *
 * Upsert keyed on (scope, period): setting a limit that already exists
 * overwrites it in place. A Claude Enterprise organization sets `user`
 * limits. Its seat-tier, group, and organization-level defaults are configured
 * in claude.ai. A Claude Console organization sets `organization` and
 * `workspace` limits, which are monthly and always carry an amount. Setting those
 * limits is in an early access preview. To request access, contact your
 * Anthropic account team.
 *
 * @see Anthropic\Services\Beta\Organization\SpendLimitsService::set()
 *
 * @phpstan-import-type ScopeShape from \Anthropic\Beta\Organization\SpendLimits\SpendLimitSetParams\Scope
 * @phpstan-import-type ScopeVariants from \Anthropic\Beta\Organization\SpendLimits\SpendLimitSetParams\Scope
 *
 * @phpstan-type SpendLimitSetParamsShape = array{
 *   amount: string|null,
 *   scope: ScopeShape,
 *   period?: null|SpendLimitPeriod|value-of<SpendLimitPeriod>,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class SpendLimitSetParams implements BaseModel
{
    /** @use SdkModel<SpendLimitSetParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Limit amount as a non-negative integer decimal string in the minor unit of the organization's billing currency (cents for USD): "50000" is $500.00. `null` sets an explicit no-limit override for this scope and `period` only — each period resolves independently, so caps for other periods still apply.
     */
    #[Required]
    public ?string $amount;

    /**
     * What the limit applies to. Claude Enterprise organizations set `user` limits. Claude Console organizations set `organization` and `workspace` limits. Any other combination returns 400. Setting `organization` and `workspace` limits through the API is in an early access preview. To request access, contact your Anthropic account team.
     *
     * @var ScopeVariants $scope
     */
    #[Required(union: Scope::class)]
    public SpendLimitUserScope|SpendLimitOrganizationScope|SpendLimitWorkspaceScope $scope;

    /** @var value-of<SpendLimitPeriod>|null $period */
    #[Optional(enum: SpendLimitPeriod::class)]
    public ?string $period;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new SpendLimitSetParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SpendLimitSetParams::with(amount: ..., scope: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SpendLimitSetParams())->withAmount(...)->withScope(...)
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
     * @param ScopeShape $scope
     * @param SpendLimitPeriod|value-of<SpendLimitPeriod>|null $period
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        ?string $amount,
        SpendLimitUserScope|array|SpendLimitOrganizationScope|SpendLimitWorkspaceScope $scope,
        SpendLimitPeriod|string|null $period = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        $self['amount'] = $amount;
        $self['scope'] = $scope;

        null !== $period && $self['period'] = $period;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Limit amount as a non-negative integer decimal string in the minor unit of the organization's billing currency (cents for USD): "50000" is $500.00. `null` sets an explicit no-limit override for this scope and `period` only — each period resolves independently, so caps for other periods still apply.
     */
    public function withAmount(?string $amount): self
    {
        $self = clone $this;
        $self['amount'] = $amount;

        return $self;
    }

    /**
     * What the limit applies to. Claude Enterprise organizations set `user` limits. Claude Console organizations set `organization` and `workspace` limits. Any other combination returns 400. Setting `organization` and `workspace` limits through the API is in an early access preview. To request access, contact your Anthropic account team.
     *
     * @param ScopeShape $scope
     */
    public function withScope(
        SpendLimitUserScope|array|SpendLimitOrganizationScope|SpendLimitWorkspaceScope $scope,
    ): self {
        $self = clone $this;
        $self['scope'] = $scope;

        return $self;
    }

    /**
     * @param SpendLimitPeriod|value-of<SpendLimitPeriod> $period
     */
    public function withPeriod(SpendLimitPeriod|string $period): self
    {
        $self = clone $this;
        $self['period'] = $period;

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
