<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces;

enum WorkspaceChangedConcurrentlyField: string
{
    case INFERENCE_DATA_PRIVACY_HUMAN_REVIEW = 'inference_data_privacy.human_review';
}
