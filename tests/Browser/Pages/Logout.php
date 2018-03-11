<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

class Logout extends BasePage
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/home';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url());
        $browser->assertVisible('@navbarDropdown');
        $browser->click('@navbarDropdown')
            ->waitFor('.dropdown-item')
            ->assertVisible('.dropdown-item');
        $browser->click('.dropdown-item')
//            ->pause(3000)
//            ->visit('/')
        ->assertSeeIn('div', 'Larav')
            ->assertTitle('Laravel')
                ->assertSee('Laravel789')
//            ->assertSee('Login')
        ;
            //        $browser->click('.dropdown-item')
//            ->whenAvailable('@navbarDropdown', function ($dropdown_item) {
//                $dropdown_item->assertSee('Logout');
//            }
//            );
//        ->click('@dropdown-item')
//        ->assertSee('Login');

    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@navbarDropdown' => '#navbarDropdown',
        ];
    }

}
