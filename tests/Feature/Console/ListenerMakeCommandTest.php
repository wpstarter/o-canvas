<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Tests\Feature\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ListenerMakeCommandTest extends TestCase
{
    protected $files = [
        'app/Listeners/HelloWorld.php',
        'tests/Feature/Listeners/HelloWorldTest.php',
    ];

    #[Test]
    public function it_can_generate_listener_file()
    {
        $this->artisan('make:listener', ['name' => 'HelloWorld', '--event' => '', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Listeners;',
            'class HelloWorld',
            'public function handle(object $event)',
        ], 'app/Listeners/HelloWorld.php');

        $this->assertFileNotContains([
            'class HelloWorld implements ShouldQueue',
        ], 'app/Listeners/HelloWorld.php');
    }

    #[Test]
    public function it_can_generate_listener_for_event_file()
    {
        $this->artisan('make:listener', ['name' => 'HelloWorld', '--event' => 'FooCreated', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Listeners;',
            'use App\Events\FooCreated;',
            'class HelloWorld',
            'public function handle(FooCreated $event)',
        ], 'app/Listeners/HelloWorld.php');
    }

    #[Test]
    public function it_can_generate_listener_for_laravel_event_file()
    {
        $this->artisan('make:listener', ['name' => 'HelloWorld', '--event' => 'WpStarter\Auth\Events\Login', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Listeners;',
            'use WpStarter\Auth\Events\Login;',
            'class HelloWorld',
            'public function handle(Login $event)',
        ], 'app/Listeners/HelloWorld.php');
    }

    #[Test]
    public function it_can_generate_queued_listener_file()
    {
        $this->artisan('make:listener', ['name' => 'HelloWorld', '--event' => '', '--queued' => true, '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Listeners;',
            'use WpStarter\Contracts\Queue\ShouldQueue;',
            'use WpStarter\Queue\InteractsWithQueue;',
            'class HelloWorld implements ShouldQueue',
            'public function handle(object $event)',
        ], 'app/Listeners/HelloWorld.php');
    }

    #[Test]
    public function it_can_generate_queued_listener_with_event_file()
    {
        $this->artisan('make:listener', ['name' => 'HelloWorld', '--queued' => true, '--event' => 'FooCreated', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Listeners;',
            'use App\Events\FooCreated;',
            'use WpStarter\Contracts\Queue\ShouldQueue;',
            'use WpStarter\Queue\InteractsWithQueue;',
            'class HelloWorld implements ShouldQueue',
            'public function handle(FooCreated $event)',
        ], 'app/Listeners/HelloWorld.php');
    }

    #[Test]
    public function it_can_generate_queued_listener_with_laravel_event_file()
    {
        $this->artisan('make:listener', ['name' => 'HelloWorld', '--queued' => true, '--event' => 'WpStarter\Auth\Events\Login', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Listeners;',
            'use WpStarter\Auth\Events\Login;',
            'use WpStarter\Contracts\Queue\ShouldQueue;',
            'use WpStarter\Queue\InteractsWithQueue;',
            'class HelloWorld implements ShouldQueue',
            'public function handle(Login $event)',
        ], 'app/Listeners/HelloWorld.php');
    }

    #[Test]
    public function it_can_generate_listener_file_with_tests()
    {
        $this->artisan('make:listener', ['name' => 'HelloWorld', '--event' => '', '--test' => true, '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFilenameExists('app/Listeners/HelloWorld.php');
        $this->assertFilenameExists('tests/Feature/Listeners/HelloWorldTest.php');
    }
}
