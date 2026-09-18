<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The tool filter variant under which only the named tools' results
 * contribute.
 *
 * @phpstan-import-type WebFetchURLSourceToolReferenceShape from \Anthropic\Messages\WebFetchURLSourceToolReference
 *
 * @phpstan-type WebFetchURLSourceOnlyShape = array{
 *   tools: list<WebFetchURLSourceToolReference|WebFetchURLSourceToolReferenceShape>,
 *   type: 'only',
 * }
 */
final class WebFetchURLSourceOnly implements BaseModel
{
    /** @use SdkModel<WebFetchURLSourceOnlyShape> */
    use SdkModel;

    /** @var 'only' $type */
    #[Required(type: new ConstantOf('only'))]
    public string $type = 'only';

    /** @var list<WebFetchURLSourceToolReference> $tools */
    #[Required(list: WebFetchURLSourceToolReference::class)]
    public array $tools;

    /**
     * `new WebFetchURLSourceOnly()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WebFetchURLSourceOnly::with(tools: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WebFetchURLSourceOnly)->withTools(...)
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
     * @param list<WebFetchURLSourceToolReference|WebFetchURLSourceToolReferenceShape> $tools
     */
    public static function with(array $tools): self
    {
        $self = new self;

        $self['tools'] = $tools;

        return $self;
    }

    /**
     * @param list<WebFetchURLSourceToolReference|WebFetchURLSourceToolReferenceShape> $tools
     */
    public function withTools(array $tools): self
    {
        $self = clone $this;
        $self['tools'] = $tools;

        return $self;
    }

    /**
     * @param 'only' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
