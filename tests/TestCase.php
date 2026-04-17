<?php

namespace Tenthfeet\Pdf\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Tenthfeet\Pdf\PdfServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            PdfServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
    }
}
