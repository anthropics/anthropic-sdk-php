<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplace;

/**
 * Outcome of the plugin marketplace's most recent synchronization: one of `success`, `in_progress`, `failed_content`, `failed_transient`, `failed_auth`, `failed_limits`; a value this API does not yet name is returned as stored. Null until a synchronization is first attempted — so always for a `manual` plugin marketplace.
 */
enum SyncStatus: string
{
    case FAILED_AUTH = 'failed_auth';

    case FAILED_CONTENT = 'failed_content';

    case FAILED_LIMITS = 'failed_limits';

    case FAILED_TRANSIENT = 'failed_transient';

    case IN_PROGRESS = 'in_progress';

    case SUCCESS = 'success';
}
