<?php

namespace Tests;

use BladeScript\ServiceProvider as BladeScriptServiceProvider;
use BladeStyle\ServiceProvider as BladeStyleServiceProvider;
use Fjord\Ui\FjordUiServiceProvider;
use Illuminate\Http\Testing\FileFactory;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use ReflectionClass;
use ReflectionProperty;

class TestCase extends OrchestraTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown(): void
    {
        // $this->artisan('view:clear');

        parent::tearDown();
    }

    protected function getPackageProviders($app)
    {
        // dd(class_exists(BladeStyleServiceProvider::class));

        return [
            BladeStyleServiceProvider::class,
            BladeScriptServiceProvider::class,
            FjordUiServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    /**
     * Calling protected or private class method.
     *
     * @param  mixed|string $abstract
     * @param  string       $method
     * @param  array        $params
     * @return mixed
     */
    protected function callUnaccessibleMethod($abstract, string $method, array $params = [])
    {
        $class = $abstract;
        if (! is_string($abstract)) {
            $class = get_class($abstract);
        }

        $class = new ReflectionClass($class);
        $method = $class->getMethod($method);
        $method->setAccessible(true);

        if ($method->isStatic()) {
            return $method->invokeArgs(null, $params);
        }

        return $method->invokeArgs($abstract, $params);
    }

    /**
     * Set protected or private class property value.
     *
     * @param  mixed  $instance
     * @param  string $property
     * @param  mixed  $value
     * @return void
     */
    public function setUnaccessibleProperty($instance, string $property, $value)
    {
        $reflection = new ReflectionProperty(get_class($instance), $property);
        $reflection->setAccessible(true);
        $value = $reflection->setValue($instance, $value);
    }

    /**
     * Get protected or private class property value.
     *
     * @param  mixed  $instance
     * @param  string $property
     * @param  mixed  $value
     * @return mixed
     */
    public function getUnaccessibleProperty($instance, string $property)
    {
        $reflection = new ReflectionProperty(get_class($instance), $property);
        $reflection->setAccessible(true);

        return $reflection->getValue($instance);
    }

    /**
     * Assert class has trait.
     *
     * @param  string       $trait
     * @param  string|mixed $class
     * @return void
     */
    public function assertHasTrait(string $trait, $class)
    {
        $traits = array_flip(class_uses_recursive($class));
        $this->assertArrayHasKey($trait, $traits);
    }

    /**
     * Create new closure mock.
     *
     * @return ClosureMock
     */
    public function mockClosure()
    {
        return new ClosureMock;
    }

    /**
     * Create TestDom from blade template.
     *
     * @param  string  $template
     * @param  array   $data
     * @return TestDom
     */
    public function blade($template, $data = [])
    {
        return new TestDom(
            $this->renderBlade(Str::random(5), $template, $data)
        );
    }

    /**
     * Create view that renders the given content.
     *
     * @param  string $name
     * @param  string $content
     * @param  array  $data
     * @return string
     */
    public function renderBlade($name, $content, $data = [])
    {
        $file = (new FileFactory)->createWithContent("{$name}.blade.php", Blade::compileString($content));

        $view = new View(
            $this->app['view'],
            $this->app['view.engine.resolver']->resolve('blade'),
            $name,
            $file->path(),
            $data
        );

        return $view->render();
    }
}
