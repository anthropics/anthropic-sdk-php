<?php

declare(strict_types=1);

namespace Anthropic\Beta\Files;

use Anthropic\Beta\Files\BetaDeletedFile\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaDeletedFileShape = array{
 *   id: string, type?: null|Type|value-of<Type>
 * }
 */
final class BetaDeletedFile implements BaseModel
{
    /** @use SdkModel<BetaDeletedFileShape> */
    use SdkModel;

    /**
     * ID of the deleted file.
     */
    #[Required]
    public string $id;

    /**
     * Deleted object type.
     *
     * For file deletion, this is always `"file_deleted"`.
     *
     * @var value-of<Type>|null $type
     */
    #[Optional(enum: Type::class)]
    public ?string $type;

    /**
     * `new BetaDeletedFile()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaDeletedFile::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaDeletedFile)->withID(...)
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
     * @param Type|value-of<Type>|null $type
     */
    public static function with(string $id, Type|string|null $type = null): self
    {
        $self = new self;

        $self['id'] = $id;

        null !== $type && $self['type'] = $type;

        return $self;
    }

    /**
     * ID of the deleted file.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
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
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
