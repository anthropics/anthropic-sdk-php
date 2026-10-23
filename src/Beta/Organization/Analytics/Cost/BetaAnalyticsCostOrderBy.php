<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics\Cost;

enum BetaAnalyticsCostOrderBy: string
{
    case AMOUNT = 'amount';

    case LIST_AMOUNT = 'list_amount';

    case TIME = 'time';
}
