<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Tool invocation directly from the model.
 *
 * @phpstan-type DirectCallerShape = array{type: 'direct'}
 */
final class DirectCaller implements BaseModel
{
    /** @use SdkModel<DirectCallerShape> */
    use SdkModel;

    /** @var 'direct' $type */
    #[Required]
    public string $type = 'direct';

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(): self
    {
        return new self;
    }

    /**
     * @param 'direct' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
