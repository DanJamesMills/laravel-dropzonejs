<?php

namespace Danjamesmills\LaravelDropzonejs\Tests;

use Orchestra\Testbench\TestCase;
use Danjamesmills\LaravelDropzonejs\LaravelDropzonejsServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [LaravelDropzonejsServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
