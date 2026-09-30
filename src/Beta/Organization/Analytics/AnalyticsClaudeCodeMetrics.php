<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Claude Code activity metrics for a single user on a given day.
 *
 * @phpstan-import-type AnalyticsCoreCodeMetricsShape from \Anthropic\Beta\Organization\Analytics\AnalyticsCoreCodeMetrics
 * @phpstan-import-type AnalyticsToolActionsShape from \Anthropic\Beta\Organization\Analytics\AnalyticsToolActions
 *
 * @phpstan-type AnalyticsClaudeCodeMetricsShape = array{
 *   coreMetrics: AnalyticsCoreCodeMetrics|AnalyticsCoreCodeMetricsShape,
 *   toolActions: AnalyticsToolActions|AnalyticsToolActionsShape,
 * }
 */
final class AnalyticsClaudeCodeMetrics implements BaseModel
{
    /** @use SdkModel<AnalyticsClaudeCodeMetricsShape> */
    use SdkModel;

    /**
     * Core Claude Code activity metrics for a single user on a given day.
     */
    #[Required('core_metrics')]
    public AnalyticsCoreCodeMetrics $coreMetrics;

    /**
     * Per-tool accepted/rejected counts for Claude Code file modification tools.
     */
    #[Required('tool_actions')]
    public AnalyticsToolActions $toolActions;

    /**
     * `new AnalyticsClaudeCodeMetrics()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsClaudeCodeMetrics::with(coreMetrics: ..., toolActions: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsClaudeCodeMetrics)->withCoreMetrics(...)->withToolActions(...)
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
     * @param AnalyticsCoreCodeMetrics|AnalyticsCoreCodeMetricsShape $coreMetrics
     * @param AnalyticsToolActions|AnalyticsToolActionsShape $toolActions
     */
    public static function with(
        AnalyticsCoreCodeMetrics|array $coreMetrics,
        AnalyticsToolActions|array $toolActions,
    ): self {
        $self = new self;

        $self['coreMetrics'] = $coreMetrics;
        $self['toolActions'] = $toolActions;

        return $self;
    }

    /**
     * Core Claude Code activity metrics for a single user on a given day.
     *
     * @param AnalyticsCoreCodeMetrics|AnalyticsCoreCodeMetricsShape $coreMetrics
     */
    public function withCoreMetrics(
        AnalyticsCoreCodeMetrics|array $coreMetrics
    ): self {
        $self = clone $this;
        $self['coreMetrics'] = $coreMetrics;

        return $self;
    }

    /**
     * Per-tool accepted/rejected counts for Claude Code file modification tools.
     *
     * @param AnalyticsToolActions|AnalyticsToolActionsShape $toolActions
     */
    public function withToolActions(
        AnalyticsToolActions|array $toolActions
    ): self {
        $self = clone $this;
        $self['toolActions'] = $toolActions;

        return $self;
    }
}
