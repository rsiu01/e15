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
     * @group runThisTest
     */
    public function testAddDevice()
    {
        $this->browse(function (Browser $browser) {
            $user = factory(User::class)->create();
            $slug = $this->faker->word;
            
            # make sure to login first before testing add device
            $browser->logout()
                    ->visit('/login')
                    ->type('@email-input', $user->email)
                    ->type('@password-input', 'helloworld')
                    ->click('@login-button')

                    ->visit('/devices')
                    ->click('@add-device-link')
                    ->type('@slug-input', $slug)
                    ->type('@location-input', 'N/A')
                    ->type('@low_temperature-input', '35')
                    ->type('@high_temperature-input', '39')
                    ->type('@calibration_offset-input', '0')
                    ->scrollTo('@submit-button')
                    ->click('@submit-button')
                    ->assertSee($slug);
        });
    }

    /**
    * Tests deleting a device
    *
    * @group runThisTest
    */
    public function testAddDevice()
    {
        $this->browse(function (Browser $browser) {
            $device = factory(Device::class)->create();
             
             
            # make sure to login first before testing add device
            $browser->visit('/devices')
                     ->click('@add-device-link')
                     ->type('@slug-input', $slug)
                     ->type('@location-input', 'N/A')
                     ->type('@low_temperature-input', '35')
                     ->type('@high_temperature-input', '39')
                     ->type('@calibration_offset-input', '0')
                     ->scrollTo('@submit-button')
                     ->click('@submit-button')
                     ->assertSee($slug);
        });
    }
}
