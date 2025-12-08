<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaAPIErrorShape = array{message: string, type: 'api_error'}
 */
final class BetaAPIError implements BaseModel
{
    /** @use SdkModel<BetaAPIErrorShape> */
    use SdkModel;

    /** @var 'api_error' $type */
    #[Required]
    public string $type = 'api_error';

    #[Required]
    public string $message;

    /**
     * `new BetaAPIError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaAPIError::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaAPIError)->withMessage(...)
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
    public static function with(string $message = 'Internal server error'): self
    {
        $obj = new self;

        $obj['message'] = $message;

        return $obj;
    }

    public function withMessage(string $message): self
    {
        $obj = clone $this;
        $obj['message'] = $message;

        return $obj;
    }
}
