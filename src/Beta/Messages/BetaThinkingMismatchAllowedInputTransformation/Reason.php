<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaThinkingMismatchAllowedInputTransformation;

/**
 * Which binding check the block failed; the block was shown to the model all
 * the same. Always `prefix_binding_mismatch` today — the conversation before
 * the block differs from the conversation it was created in, or the block
 * carries no record of one on a model that requires it. Were the check
 * enforced for this request, the block would have been removed or the request
 * rejected (`thinking.block_binding.prefix_mismatch_behavior`). A removal also
 * takes the rest of that turn's consecutive thinking blocks, whereas here each
 * block is checked on its own, so `thinking_mismatch_allowed` entries are a
 * lower bound on what enforcement would remove.
 */
enum Reason: string
{
    case MODEL_BINDING_MISMATCH = 'model_binding_mismatch';

    case PREFIX_BINDING_MISMATCH = 'prefix_binding_mismatch';

    case ORGANIZATION_BINDING_MISMATCH = 'organization_binding_mismatch';

    case END_USER_BINDING_MISMATCH = 'end_user_binding_mismatch';
}
