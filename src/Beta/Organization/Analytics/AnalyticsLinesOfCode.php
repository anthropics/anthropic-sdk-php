<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Lines of code added and removed via Claude Code.
 *
 * @phpstan-type AnalyticsLinesOfCodeShape = array{
 *   addedCount: int, removedCount: int
 * }
 */
final class AnalyticsLinesOfCode implements BaseModel
{
    /** @use SdkModel<AnalyticsLinesOfCodeShape> */
    use SdkModel;

    /**
     * Lines of code added.
     */
    #[Required('added_count')]
    public int $addedCount;

    /**
     * Lines of code removed.
     */
    #[Required('removed_count')]
    public int $removedCount;

    /**
     * `new AnalyticsLinesOfCode()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsLinesOfCode::with(addedCount: ..., removedCount: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsLinesOfCode)->withAddedCount(...)->withRemovedCount(...)
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
     */
    public static function with(int $addedCount, int $removedCount): self
    {
        $self = new self;

        $self['addedCount'] = $addedCount;
        $self['removedCount'] = $removedCount;

        return $self;
    }

    /**
     * Lines of code added.
     */
    public function withAddedCount(int $addedCount): self
    {
        $self = clone $this;
        $self['addedCount'] = $addedCount;

        return $self;
    }

    /**
     * Lines of code removed.
     */
    public function withRemovedCount(int $removedCount): self
    {
        $self = clone $this;
        $self['removedCount'] = $removedCount;

        return $self;
    }
}
