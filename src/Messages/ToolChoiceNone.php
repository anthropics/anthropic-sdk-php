<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The model will not be allowed to use tools.
 *
 * @phpstan-type tool_choice_none = array{type: string}
 */
final class ToolChoiceNone implements BaseModel
{
    /** @use SdkModel<tool_choice_none> */
    use SdkModel;

    #[Api]
    public string $type = 'none';

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(): self
    {
        return new self;
    }
}
