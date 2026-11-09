<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\ConflictException;
use Anthropic\Core\Util;

/**
 * The marketplace already holds this name. `plugin_id` is the Plugin that holds it, and can be absent.
 */
final class PluginNameTakenException extends ConflictException
{
    /** @var string */
    protected const DESC = 'Anthropic Plugin Name Taken Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'plugin_name_taken'
     */
    public function getErrorCode(): string
    {
        return 'plugin_name_taken';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): PluginNameTakenErrorDetails
    {
        $details = Conversion::coerce(
            PluginNameTakenErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof PluginNameTakenErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
