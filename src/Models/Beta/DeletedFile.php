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
    public ?string $type = 'file_deleted';

    /**
     * You must use named parameters to construct this object.
     *
     * @param null|Type::* $type
     */
    final public function __construct(string $id, ?string $type = null)
    {
        $this->id = $id;

        self::_introspect();
        $this->unsetOptionalProperties();

        null != $type && $this->type = $type;
    }
}
