<?php

declare(strict_types=1);

namespace Anthropic\Beta\Files;

use Anthropic\Beta\Files\DeletedFile\Type;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkResponse;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\Contracts\ResponseConverter;

/**
 * @phpstan-type DeletedFileShape = array{id: string, type?: value-of<Type>|null}
 */
final class DeletedFile implements BaseModel, ResponseConverter
{
    /** @use SdkModel<DeletedFileShape> */
    use SdkModel;

    use SdkResponse;

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
     * @var value-of<Type>|null $type
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
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Type|value-of<Type> $type
     */
    public static function with(string $id, Type|string|null $type = null): self
    {
        $obj = new self;

        $obj['id'] = $id;

        null !== $type && $obj['type'] = $type;

        return $obj;
    }

    /**
     * ID of the deleted file.
     */
    public function withID(string $id): self
    {
        $obj = clone $this;
        $obj['id'] = $id;

        return $obj;
    }

    /**
     * Deleted object type.
     *
     * For file deletion, this is always `"file_deleted"`.
     *
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $obj = clone $this;
        $obj['type'] = $type;

        return $obj;
    }
}
