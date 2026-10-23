<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    public function test_admin_logout_redirects_to_login_and_ends_the_session(): void
    {
        $this->actingAs(new User([
            'name' => 'School admin',
            'role' => 'admin',
        ]));

        $response = $this->post(route('logout'));

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('success', 'Anda telah berhasil keluar dari sistem.');
        $this->assertGuest();

        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Login administrator SIPESAN SMPN 2 Purwakarta');
    }
}
