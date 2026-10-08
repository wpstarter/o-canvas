<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Tests\Feature\TestCase;
use PHPUnit\Framework\Attributes\Test;

class JobMakeCommandTest extends TestCase
{
    protected $files = [
        'app/Jobs/FooCreated.php',
        'tests/Feature/Jobs/FooCreatedTest.php',
    ];

    #[Test]
    public function it_can_generate_job_file()
    {
        $this->artisan('make:job', ['name' => 'FooCreated'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Jobs;',
            'use WpStarter\Contracts\Queue\ShouldQueue;',
            'use WpStarter\Foundation\Queue\Queueable;',
            'class FooCreated implements ShouldQueue',
            '    use Queueable;',
        ], 'app/Jobs/FooCreated.php');

        $this->assertFileNotContains([
            'use WpStarter\Bus\Queueable;',
        ], 'app/Jobs/FooCreated.php');

        $this->assertFilenameNotExists('tests/Feature/Jobs/FooCreatedTest.php');
    }

    #[Test]
    public function it_can_generate_batched_job_file()
    {
        $this->artisan('make:job', ['name' => 'FooCreated', '--batched' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Jobs;',
            'use WpStarter\Contracts\Queue\ShouldQueue;',
            'use WpStarter\Foundation\Queue\Queueable;',
            'class FooCreated implements ShouldQueue',
            '    use Batchable, Queueable;',
        ], 'app/Jobs/FooCreated.php');

        $this->assertFileNotContains([
            'use WpStarter\Bus\Queueable;',
        ], 'app/Jobs/FooCreated.php');

        $this->assertFilenameNotExists('tests/Feature/Jobs/FooCreatedTest.php');
    }

    #[Test]
    public function it_can_generate_synced_job_file()
    {
        $this->artisan('make:job', ['name' => 'FooCreated', '--sync' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Jobs;',
            'use WpStarter\Foundation\Bus\Dispatchable;',
            'class FooCreated',
            '   use Dispatchable;',
        ], 'app/Jobs/FooCreated.php');

        $this->assertFileNotContains([
            'use WpStarter\Bus\Queueable;',
            'use WpStarter\Contracts\Queue\ShouldQueue;',
            'use WpStarter\Foundation\Queue\Queueable;',
            'use WpStarter\Queue\InteractsWithQueue;',
            'use WpStarter\Queue\SerializesModels;',
        ], 'app/Jobs/FooCreated.php');
    }

    #[Test]
    public function it_can_generate_job_file_with_tests()
    {
        $this->artisan('make:job', ['name' => 'FooCreated', '--test' => true])
            ->assertExitCode(0);

        $this->assertFilenameExists('app/Jobs/FooCreated.php');
        $this->assertFilenameExists('tests/Feature/Jobs/FooCreatedTest.php');
    }
}
