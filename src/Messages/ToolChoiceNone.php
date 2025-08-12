<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The model will not be allowed to use tools.
 *
 * @phpstan-type tool_choice_none_alias = array{type: string}
 */
final class ToolChoiceNone implements BaseModel
{
    use ModelTrait;

    #[Api]
    public string $type = 'none';

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
