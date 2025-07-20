<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_citations_config_param_alias = array{enabled?: bool}
 */
final class BetaCitationsConfigParam implements BaseModel
{
    use Model;

    #[Api(optional: true)]
    public ?bool $enabled;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(?bool $enabled = null)
    {
        self::introspect();
        $this->unsetOptionalProperties();

        null !== $enabled && $this->enabled = $enabled;
    }
}
