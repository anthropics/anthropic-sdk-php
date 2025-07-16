<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\SignatureDelta\Type;

final class SignatureDelta implements BaseModel
{
    use Model;

    #[Api]
    public string $signature;

    /** @var Type::* $type */
    #[Api]
    public string $type = 'signature_delta';

    /**
     * You must use named parameters to construct this object.
     *
     * @param Type::* $type
     */
    final public function __construct(
        string $signature,
        string $type = 'signature_delta'
    ) {
        $this->signature = $signature;
        $this->type = $type;
    }
}

SignatureDelta::_loadMetadata();
