<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsDocumentBlock\Source;
use Anthropic\Beta\Sessions\Events\ManagedAgentsDocumentBlock\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Document content, either specified directly as base64 data, as text, or as a reference via a URL.
 *
 * @phpstan-import-type SourceVariants from \Anthropic\Beta\Sessions\Events\ManagedAgentsDocumentBlock\Source
 * @phpstan-import-type SourceShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsDocumentBlock\Source
 *
 * @phpstan-type ManagedAgentsDocumentBlockShape = array{
 *   source: SourceShape,
 *   type: Type|value-of<Type>,
 *   context?: string|null,
 *   title?: string|null,
 * }
 */
final class ManagedAgentsDocumentBlock implements BaseModel
{
    /** @use SdkModel<ManagedAgentsDocumentBlockShape> */
    use SdkModel;

    /**
     * Union type for document source variants.
     *
     * @var SourceVariants $source
     */
    #[Required(union: Source::class)]
    public ManagedAgentsBase64DocumentSource|ManagedAgentsPlainTextDocumentSource|ManagedAgentsURLDocumentSource|ManagedAgentsFileDocumentSource $source;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * Additional context about the document for the model.
     */
    #[Optional(nullable: true)]
    public ?string $context;

    /**
     * The title of the document.
     */
    #[Optional(nullable: true)]
    public ?string $title;

    /**
     * `new ManagedAgentsDocumentBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsDocumentBlock::with(source: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsDocumentBlock)->withSource(...)->withType(...)
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
     * @param SourceShape $source
     * @param Type|value-of<Type> $type
     */
    public static function with(
        ManagedAgentsBase64DocumentSource|array|ManagedAgentsPlainTextDocumentSource|ManagedAgentsURLDocumentSource|ManagedAgentsFileDocumentSource $source,
        Type|string $type,
        ?string $context = null,
        ?string $title = null,
    ): self {
        $self = new self;

        $self['source'] = $source;
        $self['type'] = $type;

        null !== $context && $self['context'] = $context;
        null !== $title && $self['title'] = $title;

        return $self;
    }

    /**
     * Union type for document source variants.
     *
     * @param SourceShape $source
     */
    public function withSource(
        ManagedAgentsBase64DocumentSource|array|ManagedAgentsPlainTextDocumentSource|ManagedAgentsURLDocumentSource|ManagedAgentsFileDocumentSource $source,
    ): self {
        $self = clone $this;
        $self['source'] = $source;

        return $self;
    }

    /**
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Additional context about the document for the model.
     */
    public function withContext(?string $context): self
    {
        $self = clone $this;
        $self['context'] = $context;

        return $self;
    }

    /**
     * The title of the document.
     */
    public function withTitle(?string $title): self
    {
        $self = clone $this;
        $self['title'] = $title;

        return $self;
    }
}
