<?php

namespace Tenthfeet\Pdf\Tests\Feature;

use Tenthfeet\Pdf\Tests\TestCase;
use Tenthfeet\Pdf\PdfManager;

class ServiceProviderTest extends TestCase
{
    /** @test */
    public function it_can_register_the_pdf_manager()
    {
        $this->assertTrue($this->app->bound('pdf.manager'));
        $this->assertInstanceOf(PdfManager::class, $this->app->make('pdf.manager'));
    }

    /** @test */
    public function it_can_access_the_config()
    {
        $this->assertEquals('tcpdf', config('pdf.default'));
        $this->assertIsArray(config('pdf.drivers'));
    }
}
