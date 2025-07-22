<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_tool_text_editor20250124_alias = array{
 *   name: string, type: string, cacheControl?: BetaCacheControlEphemeral
 * }
 */
final class BetaToolTextEditor20250124 implements BaseModel
{
    use Model;

    /**
     * Name of the tool.
     *
     * This is how the tool will be called by the model and in `tool_use` blocks.
     */
    #[Api]
    public string $name = 'str_replace_editor';

    #[Api]
    public string $type = 'text_editor_20250124';

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api('cache_control', optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        ?BetaCacheControlEphemeral $cacheControl = null
    ) {
        self::introspect();
        $this->unsetOptionalProperties();

        null !== $cacheControl && $this->cacheControl = $cacheControl;
    }
}
