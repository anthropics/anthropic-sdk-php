<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type InputJSONDeltaShape = array{
 *   partial_json: string, type: 'input_json_delta'
 * }
 */
final class InputJSONDelta implements BaseModel
{
    /** @use SdkModel<InputJSONDeltaShape> */
    use SdkModel;

    /** @var 'input_json_delta' $type */
    #[Required]
    public string $type = 'input_json_delta';

    #[Required]
    public string $partial_json;

    /**
     * `new InputJSONDelta()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * InputJSONDelta::with(partial_json: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new InputJSONDelta)->withPartialJSON(...)
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
    public static function with(string $partial_json): self
    {
        $obj = new self;

        $obj['partial_json'] = $partial_json;

        return $obj;
    }

    public function withPartialJSON(string $partialJSON): self
    {
        $obj = clone $this;
        $obj['partial_json'] = $partialJSON;

        return $obj;
    }
}
