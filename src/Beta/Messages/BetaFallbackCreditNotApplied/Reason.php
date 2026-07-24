<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaFallbackCreditNotApplied;

/**
 * Why the reprice was not applied.
 *
 * A closed enum; additions to the redemption-check vocabulary arrive as
 * deliberate schema updates.
 */
enum Reason: string
{
    case BODY_MISMATCH = 'body_mismatch';

    case CONTINUATION_EXCLUDED = 'continuation_excluded';

    case CONTINUATION_ONLY = 'continuation_only';

    case EXPIRED = 'expired';

    case INVALID_TARGET_MODEL = 'invalid_target_model';

    case NOT_ENABLED = 'not_enabled';

    case REPRICE_UNAVAILABLE = 'reprice_unavailable';

    case TEMPORARILY_UNAVAILABLE = 'temporarily_unavailable';

    case VARIANT_FIELDS_PRESENT = 'variant_fields_present';

    case WRONG_ORGANIZATION = 'wrong_organization';

    case WRONG_PLATFORM = 'wrong_platform';

    case WRONG_WORKSPACE = 'wrong_workspace';
}
