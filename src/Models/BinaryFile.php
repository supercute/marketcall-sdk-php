<?php

declare(strict_types=1);

namespace Marketcall\Models;

class BinaryFile
{
    public function __construct(
        public string  $content,
        public string  $filename,
        public string  $contentType,
        public int     $size,
        public ?string $requestId = null,
    )
    {
    }

    public static function fromResponse(string $content, array $headers): self
    {
        $headersMap = self::normalizeHeaders($headers);

        return new self(
            content: $content,
            filename: self::extractFilename($headersMap['content-disposition'] ?? ''),
            contentType: $headersMap['content-type'] ?? 'application/octet-stream',
            size: (int)($headersMap['content-length'] ?? strlen($content)),
            requestId: $headersMap['x-request-id'] ?? null,
        );
    }

    private static function normalizeHeaders(array $headers): array
    {
        $normalized = [];
        foreach ($headers as $header) {
            $key = strtolower($header['key']);
            $normalized[$key] = $header['value'];
        }
        return $normalized;
    }

    private static function extractFilename(string $contentDisposition): string
    {
        if (preg_match('/filename="([^"]+)"/', $contentDisposition, $matches)) {
            return $matches[1];
        }

        if (preg_match('/filename=([^;\s]+)/', $contentDisposition, $matches)) {
            return rawurldecode($matches[1]);
        }

        return 'download';
    }

    public function save(string $path): bool
    {
        return file_put_contents($path, $this->content) !== false;
    }

    public function stream(): void
    {
        header('Content-Type: ' . $this->contentType);
        header('Content-Disposition: attachment; filename="' . $this->filename . '"');
        header('Content-Length: ' . $this->size);

        echo $this->content;
        exit;
    }
}
