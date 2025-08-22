<?php

declare(strict_types=1);

namespace Anthropic\Beta\Files;

use Anthropic\Beta\Files\DeletedFile\Type;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

final class DeletedFile implements BaseModel
{
    use SdkModel;

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
     * @var Type::*|null $type
     */
    #[Api(enum: Type::class, optional: true)]
    public ?string $type;

    /**
     * `new DeletedFile()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * DeletedFile::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new DeletedFile)->withID(...)
     * ```
     */
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
     * @param Type::*|null $type
     */
    public static function with(string $id, ?string $type = null): self
    {
        $obj = new self;

        $obj->id = $id;

        null !== $type && $obj->type = $type;

        return $obj;
    }

    /**
     * ID of the deleted file.
     */
    public function withID(string $id): self
    {
        $obj = clone $this;
        $obj->id = $id;

        return $obj;
    }

    /**
     * Deleted object type.
     *
     * For file deletion, this is always `"file_deleted"`.
     *
     * @param Type::* $type
     */
    public function withType(string $type): self
    {
        $obj = clone $this;
        $obj->type = $type;

        return $obj;
    }
}
