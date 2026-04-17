<?php

namespace Tenthfeet\Pdf\Contracts;

use Tenthfeet\Pdf\Contracts\PdfAdapter;

interface HasHeader
{
    public function header(PdfAdapter $pdf): void;
}
