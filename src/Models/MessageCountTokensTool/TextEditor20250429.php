<?php

declare(strict_types=1);

namespace Anthropic\Models\MessageCountTokensTool;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\CacheControlEphemeral;
use Anthropic\Models\MessageCountTokensTool\TextEditor20250429\Name;
use Anthropic\Models\MessageCountTokensTool\TextEditor20250429\Type;

final class TextEditor20250429 implements BaseModel
{
    use Model;

    /** @var Name::* $name */
    #[Api]
    public string $name;

    /** @var Type::* $type */
    #[Api]
    public string $type;

    #[Api('cache_control', optional: true)]
    public ?CacheControlEphemeral $cacheControl;

    /**
     * You must use named parameters to construct this object.
     *
     * @param Name::* $name
     * @param Type::* $type
     */
    final public function __construct(
        string $name,
        string $type,
        ?CacheControlEphemeral $cacheControl = null
    ) {
        $this->name = $name;
        $this->type = $type;
        $this->cacheControl = $cacheControl;
    }
}

TextEditor20250429::_loadMetadata();
