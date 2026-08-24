<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class SuperAdminPasswordEditTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'User', 'guard_name' => 'web']);
    }

    private function getOrCreateSuperAdmin(): User
    {
        $superAdmin = User::updateOrCreate(
            ['email' => 'superadmin@pdmt.local'],
            [
                'name' => 'Super Admin User',
                'password' => Hash::make('password123'),
                'role' => 'Super Admin',
                'must_change_password' => false,
            ]
        );
        $superAdmin->syncRoles(['Super Admin']);
        return $superAdmin;
    }

    public function test_super_admin_can_see_all_users_including_super_admin(): void
    {
        $superAdmin = $this->getOrCreateSuperAdmin();

        $regularUser = User::updateOrCreate(
            ['email' => 'regular_test@pdmt.local'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password123'),
                'role' => 'User',
                'must_change_password' => false,
            ]
        );

        $response = $this->actingAs($superAdmin)->get(route('users.index'));

        $response->assertStatus(200);
        $response->assertSee('superadmin@pdmt.local');
        $response->assertSee('regular_test@pdmt.local');
    }

    public function test_standard_admin_does_not_see_super_admin_in_user_list(): void
    {
        $this->getOrCreateSuperAdmin();

        $admin = User::updateOrCreate(
            ['email' => 'admin_test@pdmt.local'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'),
                'role' => 'Admin',
                'must_change_password' => false,
            ]
        );
        $admin->syncRoles(['Admin']);

        $response = $this->actingAs($admin)->get(route('users.index'));

        $response->assertStatus(200);
        $response->assertDontSee('superadmin@pdmt.local');
    }

    public function test_super_admin_can_change_own_password_with_current_password(): void
    {
        $superAdmin = $this->getOrCreateSuperAdmin();

        $response = $this->actingAs($superAdmin)->post(route('users.change-password', $superAdmin->id), [
            'current_password' => 'password123',
            'password' => 'newSecretPassword123',
            'password_confirmation' => 'newSecretPassword123',
        ]);

        $response->assertSessionHas('success');
        $this->assertTrue(Hash::check('newSecretPassword123', $superAdmin->fresh()->password));
    }

    public function test_super_admin_can_reset_another_user_password_without_current_password(): void
    {
        $superAdmin = $this->getOrCreateSuperAdmin();

        $targetUser = User::updateOrCreate(
            ['email' => 'target_test@pdmt.local'],
            [
                'name' => 'Regular User',
                'password' => Hash::make('initialPassword123'),
                'role' => 'User',
                'must_change_password' => false,
            ]
        );

        $response = $this->actingAs($superAdmin)->post(route('users.change-password', $targetUser->id), [
            'password' => 'resetPassword456',
            'password_confirmation' => 'resetPassword456',
        ]);

        $response->assertSessionHas('success');
        $this->assertTrue(Hash::check('resetPassword456', $targetUser->fresh()->password));
    }

    public function test_super_admin_reset_user_password_defaults_to_pdmt001_and_sends_email(): void
    {
        $superAdmin = $this->getOrCreateSuperAdmin();

        $targetUser = User::updateOrCreate(
            ['email' => 'resetdefault_test@pdmt.local'],
            [
                'name' => 'Default Reset User',
                'password' => Hash::make('initialPassword123'),
                'role' => 'User',
                'must_change_password' => false,
            ]
        );

        $response = $this->actingAs($superAdmin)->post(route('users.change-password', $targetUser->id), []);

        $response->assertSessionHas('success');
        $this->assertTrue(Hash::check('pdmt@001', $targetUser->fresh()->password));
        $this->assertTrue((bool)$targetUser->fresh()->must_change_password);
    }

    public function test_super_admin_reset_user_password_increments_automatically(): void
    {
        $superAdmin = $this->getOrCreateSuperAdmin();

        $user1 = User::create([
            'name' => 'User One',
            'email' => 'user1_inc@pdmt.local',
            'password' => Hash::make('secret'),
            'role' => 'User',
            'temp_password_code' => 1,
        ]);

        $user2 = User::create([
            'name' => 'User Two',
            'email' => 'user2_inc@pdmt.local',
            'password' => Hash::make('secret'),
            'role' => 'User',
        ]);

        // Reset user2 password; next code should be 2 => pdmt@002
        $this->actingAs($superAdmin)->post(route('users.change-password', $user2->id), []);
        $this->assertTrue(Hash::check('pdmt@002', $user2->fresh()->password));
        $this->assertEquals(2, $user2->fresh()->temp_password_code);

        $user3 = User::create([
            'name' => 'User Three',
            'email' => 'user3_inc@pdmt.local',
            'password' => Hash::make('secret'),
            'role' => 'User',
        ]);

        // Reset user3 password; next code should be 3 => pdmt@003
        $this->actingAs($superAdmin)->post(route('users.change-password', $user3->id), []);
        $this->assertTrue(Hash::check('pdmt@003', $user3->fresh()->password));
        $this->assertEquals(3, $user3->fresh()->temp_password_code);
    }

    public function test_super_admin_can_update_user_password_via_update_route(): void
    {
        $superAdmin = $this->getOrCreateSuperAdmin();

        $targetUser = User::updateOrCreate(
            ['email' => 'edittarget_test@pdmt.local'],
            [
                'name' => 'Edit Target User',
                'password' => Hash::make('initialPassword123'),
                'role' => 'User',
                'must_change_password' => false,
            ]
        );

        $response = $this->actingAs($superAdmin)->put(route('users.update', $targetUser->id), [
            'name' => 'Updated User Name',
            'email' => 'edittarget_test@pdmt.local',
            'role' => 'User',
            'dob' => '1995-01-01',
            'nic_number' => '199512345678',
            'phone' => '0771234567',
            'password' => 'brandNewPassword999',
        ]);

        $response->assertSessionHas('success');
        $this->assertTrue(Hash::check('brandNewPassword999', $targetUser->fresh()->password));
    }

    public function test_non_super_admin_cannot_edit_super_admin(): void
    {
        $superAdmin = $this->getOrCreateSuperAdmin();

        $admin = User::updateOrCreate(
            ['email' => 'admin_test2@pdmt.local'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'),
                'role' => 'Admin',
                'must_change_password' => false,
            ]
        );

        $response = $this->actingAs($admin)->put(route('users.update', $superAdmin->id), [
            'name' => 'Hacked Super Admin',
            'email' => 'superadmin@pdmt.local',
            'role' => 'Admin',
            'password' => 'hackedPassword',
        ]);

        $response->assertStatus(403);
    }

    public function test_super_admin_can_update_user_password_and_send_email(): void
    {
        $superAdmin = $this->getOrCreateSuperAdmin();

        $targetUser = User::updateOrCreate(
            ['email' => 'editemail_test@pdmt.local'],
            [
                'name' => 'Edit Email Target User',
                'password' => Hash::make('initialPassword123'),
                'role' => 'User',
                'must_change_password' => false,
            ]
        );

        $response = $this->actingAs($superAdmin)->put(route('users.update', $targetUser->id), [
            'name' => 'Updated User Name',
            'email' => 'editemail_test@pdmt.local',
            'role' => 'User',
            'dob' => '1995-01-01',
            'nic_number' => '199512345678',
            'phone' => '0771234567',
            'password' => 'pdmt@987',
            'send_password_email' => 1,
        ]);

        $response->assertSessionHas('success');
        $this->assertTrue(Hash::check('pdmt@987', $targetUser->fresh()->password));
    }
}
