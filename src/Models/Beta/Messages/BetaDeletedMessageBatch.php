<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaDeletedMessageBatch implements BaseModel
{
    use Model;

    #[Api]
    public string $id;

    #[Api]
    public string $type = 'message_batch_deleted';

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param string $id   `required`
     * @param string $type `required`
     */
    final public function __construct($id, $type = 'message_batch_deleted')
    {
        $this->constructFromArgs(func_get_args());
    }
}

BetaDeletedMessageBatch::_loadMetadata();
