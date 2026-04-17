<?php

namespace Tenthfeet\Pdf;

use Tenthfeet\Pdf\Contracts\PdfAdapter;
use Illuminate\Http\Response;

class PdfResponse
{
    /**
     * Create a new PDF response instance.
     */
    public function __construct(
        protected PdfAdapter $adapter
    ) {
    }

    /**
     * Return the PDF as an inline stream.
     */
    public function stream(string $fileName = 'document.pdf'): Response
    {
        return response(
            $this->output(),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => "inline; filename=\"{$fileName}\"",
                'Cache-Control' => 'no-cache, private',
            ]
        );
    }

    /**
     * Return the PDF as a download.
     */
    public function download(string $fileName = 'document.pdf'): Response
    {
        return response(
            $this->output(),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
                'Cache-Control' => 'no-cache, private',
            ]
        );
    }

    /**
     * Save the PDF to a specific path.
     */
    public function save(string $path): bool
    {
        return file_put_contents($path, $this->output()) !== false;
    }

    /**
     * Get the raw output of the PDF.
     */
    public function output(): string
    {
        return $this->adapter->Output('', 'S');
    }

    /**
     * Get the underlying adapter.
     */
    public function getAdapter(): PdfAdapter
    {
        return $this->adapter;
    }

    /**
     * Dynamically call methods on the adapter.
     */
    public function __call(string $name, array $arguments)
    {
        $result = $this->adapter->{$name}(...$arguments);

        // If the adapter returns itself (fluent), return this wrapper instead
        if ($result === $this->adapter) {
            return $this;
        }

        return $result;
    }
}
