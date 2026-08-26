<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalKeys\ExternalKeyValidateResponse;

/**
 * `success` — encrypt/decrypt roundtrip succeeded. `failure` — the roundtrip failed or timed out; see `error`.
 */
enum Status: string
{
    case FAILURE = 'failure';

    case SUCCESS = 'success';
}
