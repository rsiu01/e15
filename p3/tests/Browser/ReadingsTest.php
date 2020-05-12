<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use App\User;
use App\Device;

class ReadingsTest extends DuskTestCase
{
    /**
     * test selects a different value in dropdown which will trigger a post
     * request and display the selected value in the view
     *
     *
     */
    public function testReadingsPerPage()
    {
        $this->browse(function (Browser $browser) {
            $user = factory(User::class)->create();
            $device = factory(Device::class)->create();
            $slug = $device->slug;
      
            
             
            # make sure to login first before testing
            $browser->logout()
                    ->loginAs($user->id)
             
             # test begins
 
                    ->visit('/readings/'.$slug)
                    ->select('@numberReadings-dropdown', 1000)
                    ->assertSee('1000')
                    ->assertPresent('@chartContainer'); # chart contain present?
        });
    }

    /**
     * similar test for page dropdown
     *
     * @group runThisTest
     */

    public function testReadingsPage()
    {
        $this->browse(function (Browser $browser) {
            $user = factory(User::class)->create();
            $device = factory(Device::class)->create();
            $slug = $device->slug;
      
            
             
            # make sure to login first before testing
            $browser->logout()
                    ->loginAs($user->id)
             
             # test begins
 
                     ->visit('/readings/'.$slug)
                     ->select('@page-dropdown', 1)
                     ->assertSee('1')
                     ->assertPresent('@chartContainer'); # chart contain present?
        });
    }
}
