<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_validation_fails_for_empty_fields(): void
    {
        $response = $this->postJson('/api/login', []);

        $response->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['email', 'password']]);
    }

    public function test_login_fails_with_invalid_credentials(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'admin@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['email']]);
    }

    public function test_login_succeeds_and_returns_token(): void
    {
        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'admin@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'token',
                'access_token',
                'token_type',
                'user' => ['id', 'name', 'email'],
            ]);

        $this->assertEquals($user->id, $response->json('user.id'));
        $this->assertEquals($user->email, $response->json('user.email'));
    }

    public function test_logout_revokes_token(): void
    {
        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
        ]);

        $token = $user->createToken('test-token')->plainTextToken;

        // طلب محمي باستخدام التوكن
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/logout');

        $response->assertStatus(200)
            ->assertJson(['message' => 'تم تسجيل الخروج بنجاح']);

        // التأكد من أن التوكن تم حذفه
        $this->assertCount(0, $user->fresh()->tokens);
    }

    public function test_unauthenticated_request_is_rejected(): void
    {
        $response = $this->getJson('/api/me');
        $response->assertStatus(401);

        $response2 = $this->getJson('/api/customers');
        $response2->assertStatus(401);
    }

    public function test_me_endpoint_returns_authenticated_user(): void
    {
        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
        ]);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/me');

        $response->assertStatus(200)
            ->assertJson([
                'user' => [
                    'id' => $user->id,
                    'name' => 'Admin User',
                    'email' => 'admin@example.com',
                ],
            ]);
    }

    public function test_change_password_requires_authentication(): void
    {
        $response = $this->postJson('/api/change-password', [
            'current_password' => 'secret',
            'new_password' => 'newsecret123',
            'new_password_confirmation' => 'newsecret123',
        ]);

        $response->assertStatus(401);
    }

    public function test_change_password_validation_fails_for_mismatched_confirmation(): void
    {
        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
        ]);

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/change-password', [
            'current_password' => 'password123',
            'new_password' => 'newpassword123',
            'new_password_confirmation' => 'different-password',
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['new_password']]);
    }

    public function test_change_password_fails_when_current_password_is_incorrect(): void
    {
        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
        ]);

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/change-password', [
            'current_password' => 'wrong-current-password',
            'new_password' => 'newpassword123',
            'new_password_confirmation' => 'newpassword123',
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'message' => 'كلمة المرور الحالية غير صحيحة',
            ])
            ->assertJsonStructure(['errors' => ['current_password']]);
    }

    public function test_change_password_succeeds_and_updates_password(): void
    {
        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('oldpassword123'),
        ]);

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/change-password', [
            'current_password' => 'oldpassword123',
            'new_password' => 'newpassword123',
            'new_password_confirmation' => 'newpassword123',
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'تم تغيير كلمة المرور بنجاح']);

        // التحقق من أن كلمة المرور تغيرت في قاعدة البيانات
        $this->assertTrue(Hash::check('newpassword123', $user->fresh()->password));
    }

    public function test_change_password_revokes_other_tokens(): void
    {
        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('oldpassword123'),
        ]);

        $currentToken = $user->createToken('current-device')->plainTextToken;
        $otherToken1 = $user->createToken('other-device-1')->plainTextToken;
        $otherToken2 = $user->createToken('other-device-2')->plainTextToken;

        $this->assertCount(3, $user->fresh()->tokens);

        $response = $this->withHeader('Authorization', 'Bearer ' . $currentToken)
            ->postJson('/api/change-password', [
                'current_password' => 'oldpassword123',
                'new_password' => 'newpassword123',
                'new_password_confirmation' => 'newpassword123',
            ]);

        $response->assertStatus(200);

        // فقط التوكن الحالي يبقى، وتم إلغاء التوكنين الآخرين
        $this->assertCount(1, $user->fresh()->tokens);
    }

    public function test_login_is_throttled_after_five_attempts(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
        ]);

        // نقوم بعمل 5 محاولات فاشلة
        for ($i = 0; $i < 5; $i++) {
            $this->postJson('/api/login', [
                'email' => 'admin@example.com',
                'password' => 'wrong',
            ]);
        }

        // المحاولة السادسة يجب أن ترجع 429 Too Many Requests
        $response = $this->postJson('/api/login', [
            'email' => 'admin@example.com',
            'password' => 'wrong',
        ]);

        $response->assertStatus(429);
    }
}
