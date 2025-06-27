<?php

declare(strict_types=1);

namespace Anthropic\Core;

use Psr\Http\Message\StreamInterface;

final class GeneratorStream implements StreamInterface
{
    private string $buf = '';
    private int $pos = 0;

    /**
     * @param \Generator<string> $st
     */
    public function __construct(private \Generator $st)
    {
    }

    public function getSize(): ?int
    {
        return null;
    }

    public function eof(): bool
    {
        return !strlen($this->buf) && !$this->st->valid();
    }

    public function close(): void
    {
        $ex = new class () extends \Exception {};
        try {
            $this->st->throw(new $ex());
        } catch (\Throwable) {
        }
    }

    public function detach(): null
    {
        $this->buf = '';
        $this->close();

        return null;
    }

    public function tell(): int
    {
        return $this->pos;
    }

    public function rewind(): void
    {
        $this->buf = '';
        $this->st->rewind();
    }

    public function isSeekable(): bool
    {
        return false;
    }

    public function seek(int $offset, int $whence = SEEK_SET): void
    {
    }

    public function isWritable(): bool
    {
        return false;
    }

    public function write(string $string): int
    {
        return 0;
    }

    public function isReadable(): bool
    {
        return !$this->eof();
    }

    public function read(int $length): string
    {
        return '';
    }

    public function getContents(): string
    {
        foreach ($this->st as $chunk) {
            $this->buf .= $chunk;
        }

        return $this->buf;
    }

    public function getMetadata(?string $key = null): mixed
    {
        return null;
    }

    public function __toString(): string
    {
        try {
            return $this->getContents();
        } catch (\Throwable) {
            return '';
        }
    }
}
