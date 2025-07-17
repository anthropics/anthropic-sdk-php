<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaCodeExecutionTool20250522 implements BaseModel
{
    use Model;

    #[Api]
    public string $name = 'code_execution';

    #[Api]
    public string $type = 'code_execution_20250522';

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
