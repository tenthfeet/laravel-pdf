<?php

return [
    'default' => env('PDF_DRIVER', 'tcpdf'),

    'drivers' => [
        'tcpdf' => [
            'class' => \Tenthfeet\PdfAdapter\Adapters\TcpdfAdapter::class,
        ],
        'dompdf' => [
            'class' => null, // To be implemented
        ],
    ],
];
