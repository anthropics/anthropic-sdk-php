<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaThinkingDroppedInputTransformation;

/**
 * Which binding check removed the block: `model_binding_mismatch` — it was
 * created by a model whose reasoning the requested model may not read;
 * `prefix_binding_mismatch` — the conversation before it differs from the
 * conversation it was created in (the rest of that turn's consecutive thinking
 * blocks are removed with it, each with this reason);
 * `organization_binding_mismatch` — it was created under a different
 * organization (an Anthropic organization, AWS account or Google Cloud project)
 * and this organization is not one of its additional organizations;
 * `end_user_binding_mismatch` — it was created for a different end user, or
 * was removed by the consumer-organization binding. A block that would fail
 * several checks reports one reason, in this order of precedence:
 * `organization_binding_mismatch`, `end_user_binding_mismatch`,
 * `model_binding_mismatch`, `prefix_binding_mismatch`.
 */
enum Reason: string
{
    case MODEL_BINDING_MISMATCH = 'model_binding_mismatch';

    case PREFIX_BINDING_MISMATCH = 'prefix_binding_mismatch';

    case ORGANIZATION_BINDING_MISMATCH = 'organization_binding_mismatch';

    case END_USER_BINDING_MISMATCH = 'end_user_binding_mismatch';
}
