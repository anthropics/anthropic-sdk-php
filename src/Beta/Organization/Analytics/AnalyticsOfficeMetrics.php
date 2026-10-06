<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Office Agent activity metrics for a single user on a given day, broken out by Office product.
 *
 * @phpstan-import-type AnalyticsOfficeProductMetricsShape from \Anthropic\Beta\Organization\Analytics\AnalyticsOfficeProductMetrics
 *
 * @phpstan-type AnalyticsOfficeMetricsShape = array{
 *   excel: AnalyticsOfficeProductMetrics|AnalyticsOfficeProductMetricsShape,
 *   outlook: AnalyticsOfficeProductMetrics|AnalyticsOfficeProductMetricsShape,
 *   powerpoint: AnalyticsOfficeProductMetrics|AnalyticsOfficeProductMetricsShape,
 *   word: AnalyticsOfficeProductMetrics|AnalyticsOfficeProductMetricsShape,
 * }
 */
final class AnalyticsOfficeMetrics implements BaseModel
{
    /** @use SdkModel<AnalyticsOfficeMetricsShape> */
    use SdkModel;

    /**
     * Office Agent activity metrics for a single user on a given day within one Office product.
     */
    #[Required]
    public AnalyticsOfficeProductMetrics $excel;

    /**
     * Office Agent activity metrics for a single user on a given day within one Office product.
     */
    #[Required]
    public AnalyticsOfficeProductMetrics $outlook;

    /**
     * Office Agent activity metrics for a single user on a given day within one Office product.
     */
    #[Required]
    public AnalyticsOfficeProductMetrics $powerpoint;

    /**
     * Office Agent activity metrics for a single user on a given day within one Office product.
     */
    #[Required]
    public AnalyticsOfficeProductMetrics $word;

    /**
     * `new AnalyticsOfficeMetrics()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsOfficeMetrics::with(
     *   excel: ..., outlook: ..., powerpoint: ..., word: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsOfficeMetrics())
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
     * @param AnalyticsOfficeProductMetrics|AnalyticsOfficeProductMetricsShape $excel
     * @param AnalyticsOfficeProductMetrics|AnalyticsOfficeProductMetricsShape $outlook
     * @param AnalyticsOfficeProductMetrics|AnalyticsOfficeProductMetricsShape $powerpoint
     * @param AnalyticsOfficeProductMetrics|AnalyticsOfficeProductMetricsShape $word
     */
    public static function with(
        AnalyticsOfficeProductMetrics|array $excel,
        AnalyticsOfficeProductMetrics|array $outlook,
        AnalyticsOfficeProductMetrics|array $powerpoint,
        AnalyticsOfficeProductMetrics|array $word,
    ): self {
        $self = new self;

        $self['excel'] = $excel;
        $self['outlook'] = $outlook;
        $self['powerpoint'] = $powerpoint;
        $self['word'] = $word;

        return $self;
    }

    /**
     * Office Agent activity metrics for a single user on a given day within one Office product.
     *
     * @param AnalyticsOfficeProductMetrics|AnalyticsOfficeProductMetricsShape $excel
     */
    public function withExcel(AnalyticsOfficeProductMetrics|array $excel): self
    {
        $self = clone $this;
        $self['excel'] = $excel;

        return $self;
    }

    /**
     * Office Agent activity metrics for a single user on a given day within one Office product.
     *
     * @param AnalyticsOfficeProductMetrics|AnalyticsOfficeProductMetricsShape $outlook
     */
    public function withOutlook(
        AnalyticsOfficeProductMetrics|array $outlook
    ): self {
        $self = clone $this;
        $self['outlook'] = $outlook;

        return $self;
    }

    /**
     * Office Agent activity metrics for a single user on a given day within one Office product.
     *
     * @param AnalyticsOfficeProductMetrics|AnalyticsOfficeProductMetricsShape $powerpoint
     */
    public function withPowerpoint(
        AnalyticsOfficeProductMetrics|array $powerpoint
    ): self {
        $self = clone $this;
        $self['powerpoint'] = $powerpoint;

        return $self;
    }

    /**
     * Office Agent activity metrics for a single user on a given day within one Office product.
     *
     * @param AnalyticsOfficeProductMetrics|AnalyticsOfficeProductMetricsShape $word
     */
    public function withWord(AnalyticsOfficeProductMetrics|array $word): self
    {
        $self = clone $this;
        $self['word'] = $word;

        return $self;
    }
}
