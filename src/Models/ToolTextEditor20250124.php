<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type tool_text_editor20250124_alias = array{
 *   name: string, type: string, cacheControl?: CacheControlEphemeral
 * }
 */
final class ToolTextEditor20250124 implements BaseModel
{
    use Model;

    #[Api]
    public string $name = 'str_replace_editor';

    #[Api]
    public string $type = 'text_editor_20250124';

    #[Api('cache_control', optional: true)]
    public ?CacheControlEphemeral $cacheControl;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(?CacheControlEphemeral $cacheControl = null)
    {
        self::introspect();
        $this->unsetOptionalProperties();

        null !== $cacheControl && $this->cacheControl = $cacheControl;
    }
}
