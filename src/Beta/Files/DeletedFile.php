<?php

declare(strict_types=1);

namespace Anthropic\Beta\Files;

use Anthropic\Beta\Files\DeletedFile\Type;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type deleted_file_alias = array{id: string, type?: Type::*}
 */
final class DeletedFile implements BaseModel
{
    use Model;

    /**
     * ID of the deleted file.
     */
    #[Api]
    public string $id;

    /**
     * Deleted object type.
     *
     * For file deletion, this is always `"file_deleted"`.
     *
     * @var null|Type::* $type
     */
    #[Api(enum: Type::class, optional: true)]
    public ?string $type;

    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param null|Type::* $type
     */
    public static function from(string $id, ?string $type = null): self
    {
        $obj = new self;

        $obj->id = $id;

        null !== $type && $obj->type = $type;

        return $obj;
    }

    /**
     * ID of the deleted file.
     */
    public function setID(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Deleted object type.
     *
     * For file deletion, this is always `"file_deleted"`.
     *
     * @param Type::* $type
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
