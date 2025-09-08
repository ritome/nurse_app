<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('ユーザーが登録できる', function () {
    $response = $this->post('/register', [
        'employee_id' => 'N001',
        'full_name' => '看護 太郎',
        'role' => 'new_nurse',
        'hire_date' => '2024-04-01',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertRedirect('/dashboard');
    $this->assertDatabaseHas('users', [
        'employee_id' => 'N001',
        'full_name' => '看護 太郎',
        'role' => 'new_nurse',
    ]);
});

test('ユーザーがログインできる', function () {
    $user = User::factory()->create([
        'employee_id' => 'N001',
        'full_name' => '看護 太郎',
        'role' => 'new_nurse',
        'hire_date' => '2024-04-01',
        'password' => bcrypt('password'),
    ]);

    $response = $this->post('/login', [
        'employee_id' => 'N001',
        'password' => 'password',
    ]);

    $response->assertRedirect('/dashboard');
    $this->assertAuthenticated();
});

test('ユーザーが削除できる', function () {
    $user = User::factory()->create([
        'employee_id' => 'N001',
        'full_name' => '看護 太郎',
        'role' => 'new_nurse',
        'hire_date' => '2024-04-01',
    ]);

    $response = $this->actingAs($user)
        ->delete('/user/delete');

    $response->assertRedirect('/');
    $this->assertDatabaseMissing('users', [
        'employee_id' => 'N001',
        'deleted_at' => null,
    ]);
});
