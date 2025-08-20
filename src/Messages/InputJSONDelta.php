<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type input_json_delta_alias = array{partialJSON: string, type: string}
 */
final class InputJSONDelta implements BaseModel
{
    use SdkModel;

    #[Api]
    public string $type = 'input_json_delta';

    #[Api('partial_json')]
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
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(string $partialJSON): self
    {
        $obj = new self;

        $obj->partialJSON = $partialJSON;

        return $obj;
    }

    public function withPartialJSON(string $partialJSON): self
    {
        $obj = clone $this;
        $obj->partialJSON = $partialJSON;

        return $obj;
    }
}
