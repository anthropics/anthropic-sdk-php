<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

final class BetaRequestMCPServerToolConfiguration implements BaseModel
{
    use Model;

    /** @var null|list<string> $allowedTools */
    #[Api(
        'allowed_tools',
        type: new UnionOf([new ListOf('string'), 'null']),
        optional: true,
    )]
    public ?array $allowedTools;

    #[Api(optional: true)]
    public ?bool $enabled;

    /**
     * You must use named parameters to construct this object.
     *
     * @param null|list<string> $allowedTools
     */
    final public function __construct(
        ?array $allowedTools = null,
        ?bool $enabled = null
    ) {
        $this->allowedTools = $allowedTools;
        $this->enabled = $enabled;
    }
}

BetaRequestMCPServerToolConfiguration::__introspect();
