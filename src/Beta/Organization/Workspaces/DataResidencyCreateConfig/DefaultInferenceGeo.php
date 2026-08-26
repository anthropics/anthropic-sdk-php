<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces\DataResidencyCreateConfig;

/**
 * Default inference geo applied when requests omit the parameter. Defaults to 'global' if omitted. Must be a member of `allowed_inference_geos` unless `allowed_inference_geos` is `"unrestricted"`.
 */
enum DefaultInferenceGeo: string
{
    case GLOBAL = 'global';

    case US = 'us';
}
