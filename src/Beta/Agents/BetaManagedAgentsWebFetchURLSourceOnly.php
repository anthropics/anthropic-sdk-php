<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Only the named tools' results contribute URLs that may be fetched.
 *
 * @phpstan-import-type BetaManagedAgentsWebFetchURLSourceToolReferenceShape from \Anthropic\Beta\Agents\BetaManagedAgentsWebFetchURLSourceToolReference
 *
 * @phpstan-type BetaManagedAgentsWebFetchURLSourceOnlyShape = array{
 *   tools: list<BetaManagedAgentsWebFetchURLSourceToolReference|BetaManagedAgentsWebFetchURLSourceToolReferenceShape>,
 *   type: 'only',
 * }
 */
final class BetaManagedAgentsWebFetchURLSourceOnly implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsWebFetchURLSourceOnlyShape> */
    use SdkModel;

    /** @var 'only' $type */
    #[Required(type: new ConstantOf('only'))]
    public string $type = 'only';

    /**
     * The tools whose results contribute. Between 1 and 128 entries, each with a different name. An empty list is rejected; use "none" to allow no tool's results.
     *
     * @var list<BetaManagedAgentsWebFetchURLSourceToolReference> $tools
     */
    #[Required(list: BetaManagedAgentsWebFetchURLSourceToolReference::class)]
    public array $tools;

    /**
     * `new BetaManagedAgentsWebFetchURLSourceOnly()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsWebFetchURLSourceOnly::with(tools: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsWebFetchURLSourceOnly())->withTools(...)
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
     * @param list<BetaManagedAgentsWebFetchURLSourceToolReference|BetaManagedAgentsWebFetchURLSourceToolReferenceShape> $tools
     */
    public static function with(array $tools): self
    {
        $self = new self;

        $self['tools'] = $tools;

        return $self;
    }

    /**
     * The tools whose results contribute. Between 1 and 128 entries, each with a different name. An empty list is rejected; use "none" to allow no tool's results.
     *
     * @param list<BetaManagedAgentsWebFetchURLSourceToolReference|BetaManagedAgentsWebFetchURLSourceToolReferenceShape> $tools
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
