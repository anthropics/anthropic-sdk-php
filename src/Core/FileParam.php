<?php

declare(strict_types=1);

namespace Anthropic\Core;

/**
 * Represents a file to upload in a multipart request.
 *
 * ```php
 * // From a file on disk:
 * $client->files->upload(file: FileParam::fromResource(fopen('data.csv', 'r')));
 *
 * // From a string:
 * $client->files->upload(file: FileParam::fromString('csv data...', 'data.csv'));
 * ```
 */
final class FileParam
{
    public const DEFAULT_CONTENT_TYPE = 'application/octet-stream';

    /**
     * @param resource|string $data the file content as a resource or string
     */
    private function __construct(
        public readonly mixed $data,
        public readonly string $filename,
        public readonly string $contentType = self::DEFAULT_CONTENT_TYPE,
    ) {}

    /**
     * Create a FileParam from an open resource (e.g. from fopen()).
     *
     * @param resource $resource an open file resource
     * @param string|null $filename Override the filename. Defaults to the resource URI basename.
     * @param string $contentType override the content type
     */
    public static function fromResource(mixed $resource, ?string $filename = null, string $contentType = self::DEFAULT_CONTENT_TYPE): self
    {
        if (!is_resource($resource)) {
            throw new \InvalidArgumentException('Expected a resource, got '.get_debug_type($resource));
        }

        if (null === $filename) {
            $meta = stream_get_meta_data($resource);
            $filename = basename($meta['uri'] ?? 'upload');
        }

        return new self($resource, filename: $filename, contentType: $contentType);
    }

    /**
     * Create a FileParam from a string.
     *
     * @param string $content the file content
     * @param string $filename the filename for the Content-Disposition header
     * @param string $contentType override the content type
     */
    public static function fromString(string $content, string $filename, string $contentType = self::DEFAULT_CONTENT_TYPE): self
    {
        return new self($content, filename: $filename, contentType: $contentType);
    }
}
