<?php

namespace Tenthfeet\Pdf\Facades;

use Illuminate\Support\Facades\Facade;
use Illuminate\Http\Response;
use Tenthfeet\Pdf\PdfDocument;

/**
 * @method static \Tenthfeet\Pdf\Contracts\PdfAdapter driver(string $driver)
 * @method static \Tenthfeet\Pdf\PdfResponse make(PdfDocument $document)
 * @method static \Tenthfeet\Pdf\PdfManager manager()
 * 
 * @see \Tenthfeet\Pdf\PdfManager
 * @see \Tenthfeet\Pdf\PdfResponse
 */
class Pdf extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor()
    {
        return 'pdf.manager';
    }

    /**
     * Helper to stream a document.
     */
    public static function stream(PdfDocument $document, string $fileName = 'document.pdf'): Response
    {
        return response(
            static::make($document)->Output('', 'S'),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => "inline; filename=\"{$fileName}\"",
            ]
        );
    }

    /**
     * Helper to download a document.
     */
    public static function download(PdfDocument $document, string $fileName = 'document.pdf'): Response
    {
        return response(
            static::make($document)->Output('', 'S'),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            ]
        );
    }
}
