<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Office Agent activity metrics for a single skill on a given day, broken out by Office product.
 *
 * @phpstan-import-type AnalyticsSkillOfficeProductMetricsShape from \Anthropic\Beta\Organization\Analytics\AnalyticsSkillOfficeProductMetrics
 *
 * @phpstan-type AnalyticsSkillOfficeMetricsShape = array{
 *   excel: AnalyticsSkillOfficeProductMetrics|AnalyticsSkillOfficeProductMetricsShape,
 *   outlook: AnalyticsSkillOfficeProductMetrics|AnalyticsSkillOfficeProductMetricsShape,
 *   powerpoint: AnalyticsSkillOfficeProductMetrics|AnalyticsSkillOfficeProductMetricsShape,
 *   word: AnalyticsSkillOfficeProductMetrics|AnalyticsSkillOfficeProductMetricsShape,
 * }
 */
final class AnalyticsSkillOfficeMetrics implements BaseModel
{
    /** @use SdkModel<AnalyticsSkillOfficeMetricsShape> */
    use SdkModel;

    /**
     * Office Agent activity metrics for a single skill on a given day within one Office product.
     */
    #[Required]
    public AnalyticsSkillOfficeProductMetrics $excel;

    /**
     * Office Agent activity metrics for a single skill on a given day within one Office product.
     */
    #[Required]
    public AnalyticsSkillOfficeProductMetrics $outlook;

    /**
     * Office Agent activity metrics for a single skill on a given day within one Office product.
     */
    #[Required]
    public AnalyticsSkillOfficeProductMetrics $powerpoint;

    /**
     * Office Agent activity metrics for a single skill on a given day within one Office product.
     */
    #[Required]
    public AnalyticsSkillOfficeProductMetrics $word;

    /**
     * `new AnalyticsSkillOfficeMetrics()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsSkillOfficeMetrics::with(
     *   excel: ..., outlook: ..., powerpoint: ..., word: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsSkillOfficeMetrics())
     *   ->withExcel(...)
     *   ->withOutlook(...)
     *   ->withPowerpoint(...)
     *   ->withWord(...)
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
     * @param AnalyticsSkillOfficeProductMetrics|AnalyticsSkillOfficeProductMetricsShape $excel
     * @param AnalyticsSkillOfficeProductMetrics|AnalyticsSkillOfficeProductMetricsShape $outlook
     * @param AnalyticsSkillOfficeProductMetrics|AnalyticsSkillOfficeProductMetricsShape $powerpoint
     * @param AnalyticsSkillOfficeProductMetrics|AnalyticsSkillOfficeProductMetricsShape $word
     */
    public static function with(
        AnalyticsSkillOfficeProductMetrics|array $excel,
        AnalyticsSkillOfficeProductMetrics|array $outlook,
        AnalyticsSkillOfficeProductMetrics|array $powerpoint,
        AnalyticsSkillOfficeProductMetrics|array $word,
    ): self {
        $self = new self;

        $self['excel'] = $excel;
        $self['outlook'] = $outlook;
        $self['powerpoint'] = $powerpoint;
        $self['word'] = $word;

        return $self;
    }

    /**
     * Office Agent activity metrics for a single skill on a given day within one Office product.
     *
     * @param AnalyticsSkillOfficeProductMetrics|AnalyticsSkillOfficeProductMetricsShape $excel
     */
    public function withExcel(
        AnalyticsSkillOfficeProductMetrics|array $excel
    ): self {
        $self = clone $this;
        $self['excel'] = $excel;

        return $self;
    }

    /**
     * Office Agent activity metrics for a single skill on a given day within one Office product.
     *
     * @param AnalyticsSkillOfficeProductMetrics|AnalyticsSkillOfficeProductMetricsShape $outlook
     */
    public function withOutlook(
        AnalyticsSkillOfficeProductMetrics|array $outlook
    ): self {
        $self = clone $this;
        $self['outlook'] = $outlook;

        return $self;
    }

    /**
     * Office Agent activity metrics for a single skill on a given day within one Office product.
     *
     * @param AnalyticsSkillOfficeProductMetrics|AnalyticsSkillOfficeProductMetricsShape $powerpoint
     */
    public function withPowerpoint(
        AnalyticsSkillOfficeProductMetrics|array $powerpoint
    ): self {
        $self = clone $this;
        $self['powerpoint'] = $powerpoint;

        return $self;
    }

    /**
     * Office Agent activity metrics for a single skill on a given day within one Office product.
     *
     * @param AnalyticsSkillOfficeProductMetrics|AnalyticsSkillOfficeProductMetricsShape $word
     */
    public function withWord(
        AnalyticsSkillOfficeProductMetrics|array $word
    ): self {
        $self = clone $this;
        $self['word'] = $word;

        return $self;
    }
}
