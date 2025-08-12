<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_input_json_delta_alias = array{
 *   partialJSON: string, type: string
 * }
 */
final class BetaInputJSONDelta implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'input_json_delta';

    #[Api('partial_json')]
    public string $partialJSON;

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
    public static function new(string $partialJSON): self
    {
        $obj = new self;

        $obj->partialJSON = $partialJSON;

        return $obj;
    }

    public function setPartialJSON(string $partialJSON): self
    {
        $this->partialJSON = $partialJSON;

        return $this;
    }
}
