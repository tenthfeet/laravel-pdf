<?php

namespace Tenthfeet\Pdf\Contracts;

use Tenthfeet\Pdf\Contracts\PdfAdapter;

interface HasWatermark
{
    public function watermark(PdfAdapter $pdf, string $text = 'Watermark'): void;
}
