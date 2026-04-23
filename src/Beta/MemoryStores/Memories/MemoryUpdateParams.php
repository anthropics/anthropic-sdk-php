<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\Memories;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * UpdateMemory.
 *
 * @see Anthropic\Services\Beta\MemoryStores\MemoriesService::update()
 *
 * @phpstan-import-type ManagedAgentsPreconditionShape from \Anthropic\Beta\MemoryStores\Memories\ManagedAgentsPrecondition
 *
 * @phpstan-type MemoryUpdateParamsShape = array{
 *   memoryStoreID: string,
 *   view?: null|ManagedAgentsMemoryView|value-of<ManagedAgentsMemoryView>,
 *   content?: string|null,
 *   path?: string|null,
 *   precondition?: null|ManagedAgentsPrecondition|ManagedAgentsPreconditionShape,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class MemoryUpdateParams implements BaseModel
{
    /** @use SdkModel<MemoryUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $memoryStoreID;

    /**
     * Query parameter for view.
     *
     * @var value-of<ManagedAgentsMemoryView>|null $view
     */
    #[Optional(enum: ManagedAgentsMemoryView::class)]
    public ?string $view;

    #[Optional(nullable: true)]
    public ?string $content;

    #[Optional(nullable: true)]
    public ?string $path;

    #[Optional]
    public ?ManagedAgentsPrecondition $precondition;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new MemoryUpdateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MemoryUpdateParams::with(memoryStoreID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MemoryUpdateParams)->withMemoryStoreID(...)
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
     * @param ManagedAgentsMemoryView|value-of<ManagedAgentsMemoryView>|null $view
     * @param ManagedAgentsPrecondition|ManagedAgentsPreconditionShape|null $precondition
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        string $memoryStoreID,
        ManagedAgentsMemoryView|string|null $view = null,
        ?string $content = null,
        ?string $path = null,
        ManagedAgentsPrecondition|array|null $precondition = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        $self['memoryStoreID'] = $memoryStoreID;

        null !== $view && $self['view'] = $view;
        null !== $content && $self['content'] = $content;
        null !== $path && $self['path'] = $path;
        null !== $precondition && $self['precondition'] = $precondition;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    public function withMemoryStoreID(string $memoryStoreID): self
    {
        $self = clone $this;
        $self['memoryStoreID'] = $memoryStoreID;

        return $self;
    }

    /**
     * Query parameter for view.
     *
     * @param ManagedAgentsMemoryView|value-of<ManagedAgentsMemoryView> $view
     */
    public function withView(ManagedAgentsMemoryView|string $view): self
    {
        $self = clone $this;
        $self['view'] = $view;

        return $self;
    }

    public function withContent(?string $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    public function withPath(?string $path): self
    {
        $self = clone $this;
        $self['path'] = $path;

        return $self;
    }

    /**
     * @param ManagedAgentsPrecondition|ManagedAgentsPreconditionShape $precondition
     */
    public function withPrecondition(
        ManagedAgentsPrecondition|array $precondition
    ): self {
        $self = clone $this;
        $self['precondition'] = $precondition;

        return $self;
    }

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas
     */
    public function withBetas(array $betas): self
    {
        $self = clone $this;
        $self['betas'] = $betas;

        return $self;
    }
}
