<?php

namespace Tenthfeet\Pdf\Contracts;

use Tenthfeet\Pdf\Contracts\PdfAdapter;

interface HasFooter
{
    public function footer(PdfAdapter $pdf): void;
}
