<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaInputJSONDeltaShape = array{
 *   partialJSON: string, type?: 'input_json_delta'
 * }
 */
final class BetaInputJSONDelta implements BaseModel
{
    /** @use SdkModel<BetaInputJSONDeltaShape> */
    use SdkModel;

    /** @var 'input_json_delta' $type */
    #[Required]
    public string $type = 'input_json_delta';

    #[Required('partial_json')]
    public string $partialJSON;

    /**
     * `new BetaInputJSONDelta()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaInputJSONDelta::with(partialJSON: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaInputJSONDelta)->withPartialJSON(...)
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
        $obj = new self;

        $obj['partialJSON'] = $partialJSON;

        return $obj;
    }

    public function withPartialJSON(string $partialJSON): self
    {
        $obj = clone $this;
        $obj['partialJSON'] = $partialJSON;

        return $obj;
    }
}
