<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use Anthropic\Lib\Concerns\StructuredOutputModelTrait;
use Anthropic\Lib\Contracts\StructuredOutputModel;
use Tests\Core\SkillItem;

class ExternalPhpDocModel implements StructuredOutputModel
{
    use StructuredOutputModelTrait;

    /** @var SkillItem[] */
    public array $skills;
}
