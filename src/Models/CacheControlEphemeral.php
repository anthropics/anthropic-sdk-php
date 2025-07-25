<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type cache_control_ephemeral_alias = array{type: string}
 */
final class CacheControlEphemeral implements BaseModel
{
    use ModelTrait;

    #[Api]
    public string $type = 'ephemeral';

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
    public static function new(): self
    {
        return new self;
    }
}
