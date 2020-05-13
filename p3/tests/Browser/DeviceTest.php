<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Device;
use App\User;

class DeviceTest extends DuskTestCase
{
    use WithFaker;
    /**
     * Tests adding a device
     *
     *
     */
    public function testAddDevice()
    {
        $this->browse(function (Browser $browser) {
            $user = factory(User::class)->create();
            $slug = $this->faker->unique()->word;
            
            # make sure to login first before testing
            $browser->logout()
                    ->visit('/login')
                    ->type('@email-input', $user->email)
                    ->type('@password-input', 'helloworld')
                    ->click('@login-button')
            # test begins
                    ->visit('/devices')
                    ->click('@add-device-link')
                    ->type('@slug-input', $slug)
                    ->type('@location-input', 'N/A')
                    ->type('@low_temperature-input', '35')
                    ->type('@high_temperature-input', '39')
                    ->type('@calibration_offset-input', '0')
                    ->scrollTo('@submit-button')
                    ->click('@submit-button')
                    ->scrollTo('@slug-input')
                    ->assertSee($slug);
        });
    }

    /**
    * Tests deleting a device
    *
    *
    */
    public function testDeleteDevice()
    {
        $this->browse(function (Browser $browser) {
            $user = factory(User::class)->create();
            $device = factory(Device::class)->create();
            $slug = $device->slug;
           
            
            # make sure to login first before testing
            $browser->logout()
                    ->loginAs($user->id)
            
            # delete test begins

                    ->visit('/devices/'.$slug)
                    ->click('@delete-button')
                    ->click('@confirm-delete-button')
                    ->assertSee('“' . $slug . '” was removed.');
        });
    }

    /**
    * Tests editing a device
    *
    *
    */
    public function testEditDevice()
    {
        $this->browse(function (Browser $browser) {
            $user = factory(User::class)->create();
            $device = factory(Device::class)->create();
            $slug = $device->slug;
            $newoffset = $this->faker->randomDigit;
           
            
            # make sure to login first before testing
            $browser->logout()
                    ->loginAs($user->id)
            
            # edit test begins

                    ->visit('/devices/'.$slug)
                    ->click('@edit-button')
                    ->type('@calibration_offset-input', $newoffset)
                    ->scrollTo('@submit-button')
                    ->click('@submit-button')
                    ->scrollTo('@slug-input')
                    ->assertPresent('@flash-alert');
        });
    }
}
