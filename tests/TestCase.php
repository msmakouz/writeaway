<?php

declare(strict_types=1);

namespace Spiral\Tests\WriteAway;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Spiral\Boot\Environment;
use Spiral\Tests\WriteAway\App\App;

/**
 * @requires function \Spiral\Framework\Kernel::init
 */
abstract class TestCase extends BaseTestCase
{
    /** @var App */
    protected $app;

    /**
     * @throws \Throwable
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->app = $this->makeApp(['DEBUG' => true]);
    }

    /**
     * @param array $env
     * @return App
     * @throws \Throwable
     */
    protected function makeApp(array $env = []): App
    {
        $config = [
            'config' => __DIR__ . '/config/',
            'root'   => __DIR__ . '/App/',
            'app'    => __DIR__ . '/App/',
        ];

        return App::init($config, new Environment($env), false);
    }
}
