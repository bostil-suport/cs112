<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProjectTest extends DuskTestCase
{
    /**
     * A Dusk test testProjectTest.
     *
     * @return void
     */
    public function testProjectTest()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/project')
                    ->assertSee('List of all projects');
        });
    }
}
