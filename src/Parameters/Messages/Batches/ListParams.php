<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Messages\Batches;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Concerns\Params;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;

final class ListParams implements BaseModel
{
    use Model;
    use Params;

    #[Api(optional: true)]
    public ?string $afterID;

    #[Api(optional: true)]
    public ?string $beforeID;

    #[Api(optional: true)]
    public ?int $limit = 20;

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param null|string $afterID
     * @param null|string $beforeID
     * @param null|int    $limit
     */
    final public function __construct(
        $afterID = None::NOT_GIVEN,
        $beforeID = None::NOT_GIVEN,
        $limit = None::NOT_GIVEN,
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

ListParams::_loadMetadata();
