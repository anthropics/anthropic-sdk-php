<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Office Agent activity metrics for a single connector on a given day, broken out by Office product.
 *
 * @phpstan-import-type AnalyticsConnectorOfficeProductMetricsShape from \Anthropic\Beta\Organization\Analytics\AnalyticsConnectorOfficeProductMetrics
 *
 * @phpstan-type AnalyticsConnectorOfficeMetricsShape = array{
 *   excel: AnalyticsConnectorOfficeProductMetrics|AnalyticsConnectorOfficeProductMetricsShape,
 *   outlook: AnalyticsConnectorOfficeProductMetrics|AnalyticsConnectorOfficeProductMetricsShape,
 *   powerpoint: AnalyticsConnectorOfficeProductMetrics|AnalyticsConnectorOfficeProductMetricsShape,
 *   word: AnalyticsConnectorOfficeProductMetrics|AnalyticsConnectorOfficeProductMetricsShape,
 * }
 */
final class AnalyticsConnectorOfficeMetrics implements BaseModel
{
    /** @use SdkModel<AnalyticsConnectorOfficeMetricsShape> */
    use SdkModel;

    /**
     * Office Agent activity metrics for a single connector on a given day within one Office product.
     */
    #[Required]
    public AnalyticsConnectorOfficeProductMetrics $excel;

    /**
     * Office Agent activity metrics for a single connector on a given day within one Office product.
     */
    #[Required]
    public AnalyticsConnectorOfficeProductMetrics $outlook;

    /**
     * Office Agent activity metrics for a single connector on a given day within one Office product.
     */
    #[Required]
    public AnalyticsConnectorOfficeProductMetrics $powerpoint;

    /**
     * Office Agent activity metrics for a single connector on a given day within one Office product.
     */
    #[Required]
    public AnalyticsConnectorOfficeProductMetrics $word;

    /**
     * `new AnalyticsConnectorOfficeMetrics()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsConnectorOfficeMetrics::with(
     *   excel: ..., outlook: ..., powerpoint: ..., word: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsConnectorOfficeMetrics())
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
     * @param AnalyticsConnectorOfficeProductMetrics|AnalyticsConnectorOfficeProductMetricsShape $excel
     * @param AnalyticsConnectorOfficeProductMetrics|AnalyticsConnectorOfficeProductMetricsShape $outlook
     * @param AnalyticsConnectorOfficeProductMetrics|AnalyticsConnectorOfficeProductMetricsShape $powerpoint
     * @param AnalyticsConnectorOfficeProductMetrics|AnalyticsConnectorOfficeProductMetricsShape $word
     */
    public static function with(
        AnalyticsConnectorOfficeProductMetrics|array $excel,
        AnalyticsConnectorOfficeProductMetrics|array $outlook,
        AnalyticsConnectorOfficeProductMetrics|array $powerpoint,
        AnalyticsConnectorOfficeProductMetrics|array $word,
    ): self {
        $self = new self;

        $self['excel'] = $excel;
        $self['outlook'] = $outlook;
        $self['powerpoint'] = $powerpoint;
        $self['word'] = $word;

        return $self;
    }

    /**
     * Office Agent activity metrics for a single connector on a given day within one Office product.
     *
     * @param AnalyticsConnectorOfficeProductMetrics|AnalyticsConnectorOfficeProductMetricsShape $excel
     */
    public function withExcel(
        AnalyticsConnectorOfficeProductMetrics|array $excel
    ): self {
        $self = clone $this;
        $self['excel'] = $excel;

        return $self;
    }

    /**
     * Office Agent activity metrics for a single connector on a given day within one Office product.
     *
     * @param AnalyticsConnectorOfficeProductMetrics|AnalyticsConnectorOfficeProductMetricsShape $outlook
     */
    public function withOutlook(
        AnalyticsConnectorOfficeProductMetrics|array $outlook
    ): self {
        $self = clone $this;
        $self['outlook'] = $outlook;

        return $self;
    }

    /**
     * Office Agent activity metrics for a single connector on a given day within one Office product.
     *
     * @param AnalyticsConnectorOfficeProductMetrics|AnalyticsConnectorOfficeProductMetricsShape $powerpoint
     */
    public function withPowerpoint(
        AnalyticsConnectorOfficeProductMetrics|array $powerpoint
    ): self {
        $self = clone $this;
        $self['powerpoint'] = $powerpoint;

        return $self;
    }

    /**
     * Office Agent activity metrics for a single connector on a given day within one Office product.
     *
     * @param AnalyticsConnectorOfficeProductMetrics|AnalyticsConnectorOfficeProductMetricsShape $word
     */
    public function withWord(
        AnalyticsConnectorOfficeProductMetrics|array $word
    ): self {
        $self = clone $this;
        $self['word'] = $word;

        return $self;
    }
}
