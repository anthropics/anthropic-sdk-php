<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics\UserCostReport\UserCostReportListParams;

/**
 * Metric to rank actors by. Defaults to `amount`.
 */
enum OrderBy: string
{
    case AMOUNT = 'amount';

    case LIST_AMOUNT = 'list_amount';
}
