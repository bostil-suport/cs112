<?php

namespace Tests\Browser;

use Tests\Browser\Pages\Logout;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {


        $this->browse(function (Browser $browser) {
            $browser
                ->visit('/login')
                ->type('email', 'dvesby@gmail.com')
                ->type('password', '123456')
                ->press('Login')
                ->assertSee('You are logged in!')
                ->on(new Logout);

        });
    }
}
