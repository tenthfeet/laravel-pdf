<?php

return [
    'default' => env('PDF_DRIVER', 'tcpdf'),

    'drivers' => [
        'tcpdf' => [
            'class' => \Tenthfeet\Pdf\Adapters\TcpdfAdapter::class,
        ],
        'dompdf' => [
            'class' => null, // To be implemented
        ],
    ],
];
