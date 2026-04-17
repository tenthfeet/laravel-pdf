<?php

namespace Tenthfeet\Pdf\Contracts;

use Tenthfeet\Pdf\PdfDocument;

interface PdfAdapter
{
    /**
     * Set the document to be rendered.
     */
    public function setPdfDocument(PdfDocument $pdfDocument): void;

    /**
     * Set the top margin.
     */
    public function setTopMargin($margin): void;

    /**
     * Output the PDF.
     * 
     * @param string $dest Destination (S for string, I for inline, D for download)
     */
    public function Output($name = '', $dest = 'I');

    /**
     * Generic call to support library-specific methods.
     */
    public function __call(string $name, array $arguments);
}
