<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type InputJSONDeltaShape = array{
 *   partialJSON: string, type: 'input_json_delta'
 * }
 */
final class InputJSONDelta implements BaseModel
{
    /** @use SdkModel<InputJSONDeltaShape> */
    use SdkModel;

    /** @var 'input_json_delta' $type */
    #[Required]
    public string $type = 'input_json_delta';

    #[Required('partial_json')]
    public string $partialJSON;

    /**
     * `new InputJSONDelta()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * InputJSONDelta::with(partialJSON: ...)
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
    public static function with(string $partialJSON): self
    {
        $self = new self;

        $self['partialJSON'] = $partialJSON;

        return $self;
    }

    public function withPartialJSON(string $partialJSON): self
    {
        $self = clone $this;
        $self['partialJSON'] = $partialJSON;

        return $self;
    }
}
