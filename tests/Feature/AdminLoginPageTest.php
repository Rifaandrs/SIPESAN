<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AdminLoginPageTest extends TestCase
{
    public function test_guest_can_open_admin_login_page(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Login administrator SIPESAN SMPN 2 Purwakarta')
            ->assertSee('Username Admin')
            ->assertDontSee('Ingat Saya');
    }

    public function test_non_admin_user_can_open_admin_login_page(): void
    {
        $this->actingAs(new User([
            'name' => 'External user',
            'email' => 'user@example.test',
            'role' => 'user',
        ]));

        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Login administrator SIPESAN SMPN 2 Purwakarta');
    }

    public function test_logged_in_admin_is_sent_to_admin_dashboard(): void
    {
        $this->actingAs(new User([
            'name' => 'School admin',
            'email' => 'admin@example.test',
            'role' => 'admin',
        ]));

        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Login administrator SIPESAN SMPN 2 Purwakarta');
    }

    public function test_admin_humas_spenda_can_login_with_username(): void
    {
        $response = $this->post(route('login'), [
            'username' => 'Humas Spenda',
            'password' => 'Smpn2Pwk2026',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();
    }

    public function test_admin_account_can_login_with_username(): void
    {
        $response = $this->post(route('login'), [
            'username' => 'Admin',
            'password' => 'Admin123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();
    }

    public function test_admin_2_account_can_login_with_username(): void
    {
        $response = $this->post(route('login'), [
            'username' => 'Admin 2',
            'password' => 'admiN321',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();
    }

    public function test_login_with_wrong_password_shows_error(): void
    {
        $response = $this->from(route('login'))->post(route('login'), [
            'username' => 'Humas Spenda',
            'password' => 'WrongPassword123',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error', 'Kata sandi salah! Silakan ulangi memasukkan kata sandi Anda.');
        $response->assertSessionHasErrors(['password']);
        $this->assertGuest();
    }

    public function test_login_with_unknown_user_shows_error(): void
    {
        $response = $this->from(route('login'))->post(route('login'), [
            'username' => 'UserTidakDikenal',
            'password' => 'Smpn2Pwk2026',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error', 'Username tidak terdaftar dalam sistem.');
        $this->assertGuest();
    }

    public function test_login_with_incorrect_username_case_fails_even_with_correct_password(): void
    {
        $response = $this->from(route('login'))->post(route('login'), [
            'username' => 'admin',
            'password' => 'Admin123',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error', 'Username tidak terdaftar dalam sistem.');
        $response->assertSessionHasErrors(['username']);
        $this->assertGuest();
    }

    public function test_login_with_humas_spenda_wrong_case_fails(): void
    {
        $response = $this->from(route('login'))->post(route('login'), [
            'username' => 'humas spenda',
            'password' => 'Smpn2Pwk2026',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error', 'Username tidak terdaftar dalam sistem.');
        $response->assertSessionHasErrors(['username']);
        $this->assertGuest();
    }

    public function test_login_with_password_less_than_8_chars_fails_validation(): void
    {
        $response = $this->from(route('login'))->post(route('login'), [
            'username' => 'Humas Spenda',
            'password' => 'short12',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors(['password']);
        $this->assertGuest();
    }

    public function test_non_admin_user_cannot_login_and_gets_not_admin_notice(): void
    {
        $nonAdmin = User::firstOrCreate(
            ['name' => 'Budi Santoso'],
            [
                'email' => 'user@sipesan.local',
                'password' => bcrypt('password123'),
                'role' => 'user',
            ]
        );

        $response = $this->from(route('login'))->post(route('login'), [
            'username' => $nonAdmin->name,
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error', 'Tidak bisa melakukan login karena anda bukan admin.');
        $response->assertSessionHasErrors(['username']);
        $this->assertGuest();
    }

    public function test_non_admin_user_cannot_access_admin_dashboard_and_is_redirected_with_notice(): void
    {
        $nonAdmin = User::firstOrCreate(
            ['name' => 'Budi Santoso'],
            [
                'email' => 'user@sipesan.local',
                'password' => bcrypt('password123'),
                'role' => 'user',
            ]
        );

        $response = $this->actingAs($nonAdmin)->get(route('admin.dashboard'));

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error', 'Tidak bisa melakukan login karena anda bukan admin.');
    }
}
