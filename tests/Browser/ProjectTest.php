<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;

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

    public function testAddProjectUnauthorizedUser()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('project/create')
                ->assertSee('Login');
        });
    }

    public function testAddProjectAuthorizedUser()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(37))
                ->visit('/home')
                ->assertSee('You are logged in!')
                ->visit('project/create')
                ->assertSee('Add project');
        });
    }

}
