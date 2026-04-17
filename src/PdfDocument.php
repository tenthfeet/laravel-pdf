<?php

namespace Tenthfeet\Pdf;

use Tenthfeet\Pdf\Contracts\PdfAdapter;

abstract class PdfDocument
{
    /**
     * The driver to be used for this document.
     */
    public ?string $driver = null;

    abstract public function body(PdfAdapter $pdf): void;

    public function boot(PdfAdapter $pdf): void
    {
        $this->setupMargin($pdf);

        $pdf->AddPage();

        $this->body($pdf);
    }

    public function setupMargin(PdfAdapter $pdf): void
    {
        // set margins - using TCPDF constants if available, otherwise defaults
        $left = defined('PDF_MARGIN_LEFT') ? PDF_MARGIN_LEFT : 15;
        $top = defined('PDF_MARGIN_TOP') ? PDF_MARGIN_TOP : 27;
        $right = defined('PDF_MARGIN_RIGHT') ? PDF_MARGIN_RIGHT : 15;
        $header = defined('PDF_MARGIN_HEADER') ? PDF_MARGIN_HEADER : 5;
        $footer = defined('PDF_MARGIN_FOOTER') ? PDF_MARGIN_FOOTER : 10;
        $bottom = defined('PDF_MARGIN_BOTTOM') ? PDF_MARGIN_BOTTOM : 25;

        $pdf->SetMargins($left, $top, $right);
        $pdf->SetHeaderMargin($header);
        $pdf->SetFooterMargin($footer);
        $pdf->SetAutoPageBreak(true, $bottom);
    }

    public function watermark(PdfAdapter $pdf, string $text = 'Watermark'): void
    {
        $centerX = $pdf->getPageWidth() / 2;
        $centerY = $pdf->getPageHeight() / 2;

        $pdf->setXY(0, $centerY);
        $pdf->Rotate(55, $centerX, $centerY);
        $pdf->SetAlpha(0.2);
        $pdf->SetFont('helvetica', 'B', 72);
        $pdf->Cell(0, 0, $text, 0, 1, 'C', false, '', 0, false, 'C', 'C');
        $pdf->SetAlpha(1);
        $pdf->StopTransform();
    }
}
