<?php

declare(strict_types=1);

namespace Anthropic\Messages\MessageParam;

use Anthropic\Core\Concerns\SdkEnum;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

final class Role implements ConverterSource
{
    use SdkEnum;

    public const USER = 'user';

    public const ASSISTANT = 'assistant';
}
