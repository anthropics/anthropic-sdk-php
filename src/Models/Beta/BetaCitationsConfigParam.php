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

    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function new(?bool $enabled = null): self
    {
        $obj = new self;

        null !== $enabled && $obj->enabled = $enabled;

        return $obj;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }
}
