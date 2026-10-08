<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Tests\Feature\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ScopeMakeCommandTest extends TestCase
{
    protected $files = [
        'app/Models/Scopes/FooScope.php',
    ];

    #[Test]
    public function it_can_generate_scope_file()
    {
        $this->artisan('make:scope', ['name' => 'FooScope', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Models\Scopes;',
            'use WpStarter\Database\Eloquent\Builder;',
            'use WpStarter\Database\Eloquent\Model;',
            'use WpStarter\Database\Eloquent\Scope;',
            'class FooScope implements Scope',
        ], 'app/Models/Scopes/FooScope.php');
    }
}
