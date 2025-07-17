<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Concerns\Params;
use Anthropic\Core\Contracts\BaseModel;

final class BatchListParam implements BaseModel
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
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        ?string $afterID = null,
        ?string $beforeID = null,
        ?int $limit = null
    ) {
        self::introspect();
        $this->unsetOptionalProperties();

        null !== $afterID && $this->afterID = $afterID;
        null !== $beforeID && $this->beforeID = $beforeID;
        null !== $limit && $this->limit = $limit;
    }
}
