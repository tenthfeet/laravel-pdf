<?php

namespace Tenthfeet\Pdf\Adapters;

use TCPDF;
use Tenthfeet\Pdf\Contracts\PdfAdapter;
use Tenthfeet\Pdf\PdfDocument;
use Exception;

class TcpdfAdapter extends TCPDF implements PdfAdapter
{
    protected ?PdfDocument $pdfDocument = null;

    protected int $lastPage = 0;

    public function __construct()
    {
        if (!class_exists(TCPDF::class)) {
            throw new Exception("TCPDF library not found. Please run 'composer require tecnickcom/tcpdf'.");
        }
        parent::__construct();
    }

    public function setPdfDocument(PdfDocument $pdfDocument): void
    {
        $this->pdfDocument = $pdfDocument;

        $pdfDocument->boot($this);
    }

    protected function onRealPageCreated(): void
    {
        // Check for HasWatermark interface using a simple check or name check
        if (
            method_exists($this->pdfDocument, 'watermark') &&
            $this->pdfDocument instanceof \Tenthfeet\Pdf\Contracts\HasWatermark
        ) {
            $this->pdfDocument->watermark($this);
        }
    }

    public function AddPage($orientation = '', $format = '', $keepmargins = false, $tocpage = false)
    {
        parent::AddPage($orientation, $format, $keepmargins, $tocpage);
    }

    public function Header()
    {
        if (
            method_exists($this->pdfDocument, 'header') &&
            $this->pdfDocument instanceof \Tenthfeet\Pdf\Contracts\HasHeader
        ) {
            $this->pdfDocument->header($this);
            $this->setTopMargin($this->GetY() - 7);
        }
    }

    public function Footer()
    {
        if (
            method_exists($this->pdfDocument, 'footer') &&
            $this->pdfDocument instanceof \Tenthfeet\Pdf\Contracts\HasFooter
        ) {
            $this->pdfDocument->footer($this);
        }

        if ($this->PageNo() > $this->lastPage) {
            $this->lastPage = $this->PageNo();
            $this->onRealPageCreated();
        }
    }

    public function setTopMargin($margin): void
    {
        $left = $this->getMargins()['left'];
        $right = $this->getMargins()['right'];
        $this->SetMargins($left, $margin, $right);
    }

    public function __call($name, $arguments)
    {
        if (method_exists($this, $name)) {
            return call_user_func_array([$this, $name], $arguments);
        }
        throw new Exception("Method {$name} does not exist on TcpdfAdapter.");
    }
}
