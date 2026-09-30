<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics\AnalyticsUsageBucketedResult;

/**
 * Inference region of the usage or cost. Null unless `inference_geo` is in `group_by[]`; it can also be null on grouped rows where the region is not set (the rows that `inference_geos[]=not_available` matches).
 */
enum InferenceGeo: string
{
    case GLOBAL = 'global';

    case US = 'us';
}
