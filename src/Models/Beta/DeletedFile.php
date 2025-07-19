<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\DeletedFile\Type;

final class DeletedFile implements BaseModel
{
    use Model;

    #[Api]
    public string $id;

    /** @var null|Type::* $type */
    #[Api(optional: true)]
    public ?string $type;

    /**
     * You must use named parameters to construct this object.
     *
     * @param null|Type::* $type
     */
    final public function __construct(string $id, ?string $type = null)
    {
        self::introspect();
        $this->unsetOptionalProperties();

        $this->id = $id;

        null !== $type && $this->type = $type;
    }
}
