<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaTextEditorCodeExecutionViewResultBlock;

use Anthropic\Core\Concerns\SdkEnum;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

final class FileType implements ConverterSource
{
    use SdkEnum;

    public const TEXT = 'text';

    public const IMAGE = 'image';

    public const PDF = 'pdf';
}
