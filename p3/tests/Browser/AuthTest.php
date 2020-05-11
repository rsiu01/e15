<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\User;

class AuthTest extends DuskTestCase
{
    use withFaker;
    /**
     *
     *
     */
    public function testAuthorizationRequired()
    {
        $this->browse(function (Browser $browser) {
            $browser->logout()
                     ->visit('/readings')
                     ->assertPresent('@login-heading')
                     ->visit('/devices')
                     ->assertPresent('@login-heading');
        });
    }

    /**
     *
     */
    public function testSuccessfulRegistration()
    {
        $this->browse(function (Browser $browser) {
            $first_name = $this->faker->name;
            $last_name = $this->faker->name;

 
            $browser->visit('/login')
                     ->click('@register-link')
                     ->assertVisible('@register-heading')
                     ->type('@first_name-input', $first_name)
                     ->type('@last_name-input', $last_name)
                     ->type('@email-input', $this->faker->safeEmail())
                     ->type('@password-input', 'helloworld')
                     ->type('@password-confirm-input', 'helloworld')
                     ->scrollTo('@register-button')
                     ->click('@register-button')
                     ->assertSee($first_name);
        });
    }

    /**
     *
     */
    public function testRegisteringWithExistingEmail()
    {
        $this->browse(function (Browser $browser) {
 
             // Create a user so we can try registering with their same info
            $user = factory(User::class)->create();
 
            $browser->logout()
                     ->visit('/register')
                     ->type('first_name', $user->first_name)
                     ->type('last_name', $user->last_name)
                     ->type('email', $user->email)
                     ->type('password', 'helloworld')
                     ->type('password_confirmation', 'helloworld')
                     ->scrollTo('@register-button')
                     ->click('@register-button')
                     ->assertPresent('@error-field-email')
                     ->assertSee('The email has already been taken.');
        });
    }

    /**
    *
    */
    public function testSuccesfulLogin()
    {
        $this->browse(function (Browser $browser) {
            $user = factory(User::class)->create();
 
            $browser->logout()
                     ->visit('/login')
                     ->type('@email-input', $user->email)
                     ->type('@password-input', 'helloworld')
                     ->click('@login-button')
                     ->assertSee(strtoupper('logout'));
        });
    }

     /**
     *
     */
     public function testLoginValidation()
     {
         $this->browse(function (Browser $browser) {
             $user = factory(User::class)->create();
 
             $browser->logout()
                     ->visit('/login')
                     ->type('@email-input', $user->email)
                     ->type('@password-input', 'this-is-the-wrong-password')
                     ->click('@login-button')
                     ->assertSee('These credentials do not match our records.');
         });
     }
}
