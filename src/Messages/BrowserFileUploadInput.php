<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Set the value of a file-input element to one or more files. The target must be an
 * element reference; at least one of paths or document_ids is required.
 *
 * @phpstan-import-type BrowserRefTargetShape from \Anthropic\Messages\BrowserRefTarget
 *
 * @phpstan-type BrowserFileUploadInputShape = array{
 *   target: BrowserRefTarget|BrowserRefTargetShape,
 *   documentIDs?: list<string>|null,
 *   paths?: list<string>|null,
 *   tabID?: string|null,
 * }
 */
final class BrowserFileUploadInput implements BaseModel
{
    /** @use SdkModel<BrowserFileUploadInputShape> */
    use SdkModel;

    /**
     * An element on the page, identified by a reference from a prior `read_page` or
     * `find` result. References are scoped to the tab that produced them and become
     * stale after navigation or a major re-render.
     */
    #[Required]
    public BrowserRefTarget $target;

    /**
     * References to files the harness has staged, for deployments where the browser executor cannot read the caller's filesystem.
     *
     * @var list<string>|null $documentIDs
     */
    #[Optional('document_ids', list: 'string', nullable: true)]
    public ?array $documentIDs;

    /**
     * File paths on the browser executor's filesystem.
     *
     * @var list<string>|null $paths
     */
    #[Optional(list: 'string', nullable: true)]
    public ?array $paths;

    /**
     * Tab to act on. Defaults to the active tab when omitted.
     */
    #[Optional('tab_id', nullable: true)]
    public ?string $tabID;

    /**
     * `new BrowserFileUploadInput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BrowserFileUploadInput::with(target: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BrowserFileUploadInput())->withTarget(...)
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
     * @param BrowserRefTarget|BrowserRefTargetShape $target
     * @param list<string>|null $documentIDs
     * @param list<string>|null $paths
     */
    public static function with(
        BrowserRefTarget|array $target,
        ?array $documentIDs = null,
        ?array $paths = null,
        ?string $tabID = null,
    ): self {
        $self = new self;

        $self['target'] = $target;

        null !== $documentIDs && $self['documentIDs'] = $documentIDs;
        null !== $paths && $self['paths'] = $paths;
        null !== $tabID && $self['tabID'] = $tabID;

        return $self;
    }

    /**
     * An element on the page, identified by a reference from a prior `read_page` or
     * `find` result. References are scoped to the tab that produced them and become
     * stale after navigation or a major re-render.
     *
     * @param BrowserRefTarget|BrowserRefTargetShape $target
     */
    public function withTarget(BrowserRefTarget|array $target): self
    {
        $self = clone $this;
        $self['target'] = $target;

        return $self;
    }

    /**
     * References to files the harness has staged, for deployments where the browser executor cannot read the caller's filesystem.
     *
     * @param list<string>|null $documentIDs
     */
    public function withDocumentIDs(?array $documentIDs): self
    {
        $self = clone $this;
        $self['documentIDs'] = $documentIDs;

        return $self;
    }

    /**
     * File paths on the browser executor's filesystem.
     *
     * @param list<string>|null $paths
     */
    public function withPaths(?array $paths): self
    {
        $self = clone $this;
        $self['paths'] = $paths;

        return $self;
    }

    /**
     * Tab to act on. Defaults to the active tab when omitted.
     */
    public function withTabID(?string $tabID): self
    {
        $self = clone $this;
        $self['tabID'] = $tabID;

        return $self;
    }
}
