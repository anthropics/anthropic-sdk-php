<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type raw_content_block_stop_event_alias = array{
 *   index: int, type: string
 * }
 */
final class RawContentBlockStopEvent implements BaseModel
{
    use ModelTrait;

    #[Api]
    public string $type = 'content_block_stop';

    #[Api]
    public int $index;

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
    public static function new(int $index): self
    {
        $obj = new self;

        $obj->index = $index;

        return $obj;
    }

    public function setIndex(int $index): self
    {
        $this->index = $index;

        return $this;
    }
}
