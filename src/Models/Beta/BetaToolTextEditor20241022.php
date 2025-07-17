<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaToolTextEditor20241022 implements BaseModel
{
    use Model;

    #[Api]
    public string $name = 'str_replace_editor';

    #[Api]
    public string $type = 'text_editor_20241022';

    #[Api('cache_control', optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        ?BetaCacheControlEphemeral $cacheControl = null
    ) {
        self::_introspect();
        $this->unsetOptionalProperties();

        null !== $cacheControl && $this->cacheControl = $cacheControl;
    }
}
