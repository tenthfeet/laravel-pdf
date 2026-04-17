# Laravel PDF Bridge

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tenthfeet/laravel-pdf.svg?style=flat-square)](https://packagist.org/packages/tenthfeet/laravel-pdf)
[![Total Downloads](https://img.shields.io/packagist/dt/tenthfeet/laravel-pdf.svg?style=flat-square)](https://packagist.org/packages/tenthfeet/laravel-pdf)
[![PHP Version](https://img.shields.io/badge/php-8.2+-8892BF.svg?style=flat-square)](https://php.net)
[![Laravel Version](https://img.shields.io/badge/laravel-10%20%7C%2011%20%7C%2012%20%7C%2013-FF2D20.svg?style=flat-square)](https://laravel.com)
[![License](https://img.shields.io/packagist/l/tenthfeet/laravel-pdf.svg?style=flat-square)](LICENSE)

A flexible, driver-based PDF generation package for Laravel. This package allows you to decouple your PDF templates from specific libraries (like TCPDF or Dompdf), making your application more maintainable and ready for future engine swaps (e.g., adding Indic font support).

## Features

- **Driver-Based Architecture**: Switch between engines (TCPDF, Dompdf, etc.) without changing your template logic.
- **Unified API**: Clean, Laravel-style Facade for generating documents.
- **Template Inheritance**: Simplified base classes for building complex PDF reports.
- **Hook System**: Integrated support for Headers, Footers, and Watermarks via simple interfaces.
- **Fluent API**: Easily stream or download files.

## Requirements

- **PHP**: `^8.2`
- **Laravel**: `^10.0` | `^11.0` | `^12.0` | `^13.0`

## Installation

You can install the package via composer:

```bash
composer require tenthfeet/laravel-pdf
```

## Installation

You can install the package via composer:

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
Extend the `PdfDocument` class and implement the `body` method.

```php
namespace App\Pdf\Templates;

use Tenthfeet\Pdf\PdfDocument;
use Tenthfeet\Pdf\Contracts\PdfAdapter;

class MyReport extends PdfDocument
{
    public function body(PdfAdapter $pdf): void
    {
        $pdf->writeHTML("<p>This is the document body.</p>");
    }
}
```

### 2. Hooks & Interfaces
You can add headers, footers, or watermarks to your templates by implementing the corresponding interfaces.

#### Headers & Footers
Implement `HasHeader` or `HasFooter` to inject content into every page.

```php
use Tenthfeet\Pdf\Contracts\HasHeader;
use Tenthfeet\Pdf\Contracts\HasFooter;

class MyReport extends PdfDocument implements HasHeader, HasFooter
{
    public function header(PdfAdapter $pdf): void
    {
        $pdf->writeHTML("<h1>Page Header</h1>");
    }

    public function footer(PdfAdapter $pdf): void
    {
        $pdf->SetY(-15);
        $pdf->writeHTML("<p>Page Footnote</p>");
    }

    public function body(PdfAdapter $pdf): void
    {
        // ...
    }
}
```

#### Watermarks
Implement `HasWatermark` to add a background watermark.

```php
use Tenthfeet\Pdf\Contracts\HasWatermark;

class MyReport extends PdfDocument implements HasWatermark
{
    public function watermark(PdfAdapter $pdf, string $text = 'DRAFT'): void
    {
        // You can use the built-in helper from the base class
        parent::watermark($pdf, $text);
    }
}
```

### 3. Generate the PDF
Using the `Pdf` facade:

```php
use Tenthfeet\Pdf\Facades\Pdf;
use App\Pdf\Templates\InvoiceReport;

public function download(Request $request)
{
    $document = new InvoiceReport($request->all());

    return Pdf::make($document)->download('invoice.pdf');
}
```

### 3. Swapping Drivers
You can override the driver globally in your `.env` or per-template by adding a `$driver` property:

```php
class SpecialReport extends PdfDocument
{
    public ?string $driver = 'dompdf'; // Force this template to use Dompdf
}
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
