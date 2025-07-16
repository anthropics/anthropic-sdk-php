<?php

declare(strict_types=1);

namespace Anthropic\Models\ToolUnion;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\CacheControlEphemeral;

final class TextEditor20250429 implements BaseModel
{
    use Model;

    #[Api]
    public string $name = 'str_replace_based_edit_tool';

    #[Api]
    public string $type = 'text_editor_20250429';

    #[Api('cache_control', optional: true)]
    public ?CacheControlEphemeral $cacheControl;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(?CacheControlEphemeral $cacheControl = null)
    {
        $this->cacheControl = $cacheControl;
    }
}

TextEditor20250429::__introspect();
