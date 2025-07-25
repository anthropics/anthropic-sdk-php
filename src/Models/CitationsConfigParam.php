<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type citations_config_param_alias = array{enabled?: bool}
 */
final class CitationsConfigParam implements BaseModel
{
    use ModelTrait;

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
