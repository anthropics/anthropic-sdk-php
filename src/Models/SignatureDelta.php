<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class SignatureDelta implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'signature_delta';

    #[Api]
    public string $signature;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(string $signature)
    {
        self::introspect();

        $this->signature = $signature;
    }
}
