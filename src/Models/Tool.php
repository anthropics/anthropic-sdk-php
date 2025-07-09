<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;

class Tool implements BaseModel
{
    use Model;

    /**
     * @var array{
     *   type?: string, properties?: mixed|null, required?: list<string>|null
     * } $inputSchema
     */
    #[Api('input_schema')]
    public array $inputSchema;

    #[Api]
    public string $name;

    #[Api('cache_control', optional: true)]
    public CacheControlEphemeral $cacheControl;

    #[Api(optional: true)]
    public ?string $description;

    #[Api(optional: true)]
    public ?string $type;

    /**
     * @param array{
     *   type?: string, properties?: mixed|null, required?: list<string>|null
     * } $inputSchema
     * @param string                $name
     * @param CacheControlEphemeral $cacheControl
     * @param null|string           $description
     * @param null|string           $type
     */
    final public function __construct(
        $inputSchema,
        $name,
        $cacheControl = None::NOT_GIVEN,
        $description = None::NOT_GIVEN,
        $type = None::NOT_GIVEN,
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

Tool::_loadMetadata();
