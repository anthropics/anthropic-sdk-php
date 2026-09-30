<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics\Connectors\ConnectorListParams;

/**
 * Sort direction: `asc` or `desc`. Defaults to `asc` for the endpoint's sort column and to `desc` when `order_by` names a metric (a top-N ranking). Applies to `order_by`, or to the endpoint's default sort field when `order_by` is omitted.
 */
enum Order: string
{
    case ASC = 'asc';

    case DESC = 'desc';
}
