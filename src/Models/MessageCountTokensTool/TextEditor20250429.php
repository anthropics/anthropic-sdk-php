<?php

declare(strict_types=1);

namespace Anthropic\Models\MessageCountTokensTool;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\CacheControlEphemeral;

/**
 * @phpstan-type text_editor20250429_alias = array{
 *   name: string, type: string, cacheControl?: CacheControlEphemeral
 * }
 */
final class TextEditor20250429 implements BaseModel
{
    use Model;

    /**
     * Name of the tool.
     *
     * This is how the tool will be called by the model and in `tool_use` blocks.
     */
    #[Api]
    public string $name = 'str_replace_based_edit_tool';

    #[Api]
    public string $type = 'text_editor_20250429';

    /**
     * Create a cache control breakpoint at this content block.
     */
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
