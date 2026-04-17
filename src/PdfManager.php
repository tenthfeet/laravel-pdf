<?php

namespace Tenthfeet\Pdf;

use Illuminate\Support\Manager;
use Tenthfeet\Pdf\Adapters\TcpdfAdapter;
use InvalidArgumentException;

class PdfManager extends Manager
{
    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->container['config']['pdf.default'] ?? 'tcpdf';
    }

    /**
     * Create an instance of the TCPDF driver.
     *
     * @return \Tenthfeet\Pdf\Adapters\TcpdfAdapter
     */
    protected function createTcpdfDriver()
    {
        return new TcpdfAdapter();
    }

    /**
     * Create an instance of the Dompdf driver.
     *
     * @return mixed
     */
    protected function createDompdfDriver()
    {
        $class = $this->container['config']['pdf.drivers.dompdf.class'] ?? 'Tenthfeet\Pdf\Adapters\DompdfAdapter';
        
        if (!class_exists($class)) {
             throw new InvalidArgumentException("Driver [dompdf] is not implemented yet or class [{$class}] not found.");
        }

        return new $class();
    }

    /**
     * Render a document.
     * 
     * @param PdfDocument $document
     * @return \Tenthfeet\Pdf\PdfResponse
     */
    public function make(PdfDocument $document)
    {
        $driver = $document->driver ?: $this->getDefaultDriver();
        
        $adapter = $this->driver($driver);
        
        $adapter->setPdfDocument($document);
        
        return new PdfResponse($adapter);
    }
}
