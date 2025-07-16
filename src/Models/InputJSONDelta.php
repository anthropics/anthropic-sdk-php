<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\InputJSONDelta\Type;

final class InputJSONDelta implements BaseModel
{
    use Model;

    #[Api('partial_json')]
    public string $partialJSON;

    /** @var Type::* $type */
    #[Api]
    public string $type = 'input_json_delta';

    /**
     * You must use named parameters to construct this object.
     *
     * @param Type::* $type
     */
    final public function __construct(
        string $partialJSON,
        string $type = 'input_json_delta'
    ) {
        $this->partialJSON = $partialJSON;
        $this->type = $type;
    }
}

InputJSONDelta::_loadMetadata();
