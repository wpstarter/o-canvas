<?php

namespace WpStarter\Tests\Integration\Generators;

class ScopeMakeCommandTest extends TestCase
{
    protected $files = [
        'app/Models/Scopes/FooScope.php',
    ];

    public function testItCanGenerateScopeFile()
    {
        $this->artisan('make:scope', ['name' => 'FooScope'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Models\Scopes;',
            'use WpStarter\Database\Eloquent\Builder;',
            'use WpStarter\Database\Eloquent\Contracts\Model;',
            'use WpStarter\Database\Eloquent\Scope;',
            'class FooScope implements Scope',
        ], 'app/Models/Scopes/FooScope.php');
    }
}
