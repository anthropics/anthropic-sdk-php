<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaToolReferenceBlockShape = array{
 *   tool_name: string, type: 'tool_reference'
 * }
 */
final class BetaToolReferenceBlock implements BaseModel
{
    /** @use SdkModel<BetaToolReferenceBlockShape> */
    use SdkModel;

    /** @var 'tool_reference' $type */
    #[Required]
    public string $type = 'tool_reference';

    #[Required]
    public string $tool_name;

    /**
     * `new BetaToolReferenceBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaToolReferenceBlock::with(tool_name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaToolReferenceBlock)->withToolName(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(string $tool_name): self
    {
        $obj = new self;

        $obj['tool_name'] = $tool_name;

        return $obj;
    }

    public function withToolName(string $toolName): self
    {
        $obj = clone $this;
        $obj['tool_name'] = $toolName;

        return $obj;
    }
}
