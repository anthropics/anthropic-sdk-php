<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_tool_text_editor20250429_alias = array{
 *   name: string, type: string, cacheControl?: BetaCacheControlEphemeral
 * }
 */
final class BetaToolTextEditor20250429 implements BaseModel
{
    use Model;

    #[Api]
    public string $name = 'str_replace_based_edit_tool';

    #[Api]
    public string $type = 'text_editor_20250429';

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
