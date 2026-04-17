# Laravel PDF Bridge

A flexible, driver-based PDF generation package for Laravel. This package allows you to decouple your PDF templates from specific libraries (like TCPDF or Dompdf), making your application more maintainable and ready for future engine swaps (e.g., adding Indic font support).

## Features

- **Driver-Based Architecture**: Switch between engines (TCPDF, Dompdf, etc.) without changing your template logic.
- **Unified API**: Clean, Laravel-style Facade for generating documents.
- **Template Inheritance**: Simplified base classes for building complex PDF reports.
- **Hook System**: Integrated support for Headers, Footers, and Watermarks via simple interfaces.
- **Fluent API**: Easily stream or download files.

## Requirements

- **PHP**: ^8.2
- **Laravel**: ^10.0 | ^11.0 | ^12.0 | ^13.0

## Installation

Add the package to your `composer.json` repositories:

```json
"repositories": [
    {
        "type": "path",
        "url": "packages/tenthfeet/laravel-pdf"
    }
]
```

Then install the package:

```bash
composer require tenthfeet/laravel-pdf
```

## Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --tag=pdf-config
```

In `config/pdf.php`, you can set the default driver and configure individual engine settings:

```php
return [
    'default' => env('PDF_DRIVER', 'tcpdf'),
    'drivers' => [
        'tcpdf' => [
            'class' => \Tenthfeet\Pdf\Adapters\TcpdfAdapter::class,
        ],
        // ...
    ],
];
```

## Usage

### 1. Create a Template
Extend the `PdfDocument` class and implement hooks like `HasHeader` or `HasFooter` as needed.

```php
namespace App\Pdf\Templates;

use Tenthfeet\Pdf\PdfDocument;
use Tenthfeet\Pdf\Contracts\PdfAdapter;
use Tenthfeet\Pdf\Contracts\HasHeader;

class InvoiceReport extends PdfDocument implements HasHeader
{
    public function header(PdfAdapter $pdf): void
    {
        $pdf->writeHTML("<h1>Invoice Header</h1>");
    }

    public function body(PdfAdapter $pdf): void
    {
        $pdf->writeHTML("<p>This is the document body.</p>");
    }
}
```

### 2. Generate the PDF in a Controller

```php
use Tenthfeet\Pdf\Facades\Pdf;
use App\Pdf\Templates\InvoiceReport;

public function download(Request $request)
{
    $document = new InvoiceReport($request->all());

    return Pdf::make($document)->download('invoice.pdf');
}
```

## Swapping Drivers
You can override the driver globally in your `.env` or per-template by adding a `$driver` property:

```php
class specialReport extends PdfDocument
{
    public string $driver = 'dompdf'; // Force this template to use Dompdf
}
```

## Credits
- **Tenthfeet**
- **TCPDF** (underlying engine)

## License
MIT
