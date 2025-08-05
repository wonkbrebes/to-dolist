<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_tasks()
    {
        $this->get(route('tasks.index'))->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_see_their_tasks()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id, 'title' => 'Tugas Saya']);

        $this->actingAs($user)
            ->get(route('tasks.index'))
            ->assertStatus(200)
            ->assertSee('Tugas Saya');
    }

    public function test_authenticated_user_cannot_see_other_users_tasks()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $otherUsersTask = Task::factory()->create(['user_id' => $otherUser->id, 'title' => 'Tugas Orang Lain']);

        $this->actingAs($user)
            ->get(route('tasks.index'))
            ->assertStatus(200)
            ->assertDontSee('Tugas Orang Lain');
    }

    public function test_authenticated_user_can_create_a_task()
    {
        $user = User::factory()->create();

        $taskData = [
            'title' => 'Tugas Baru',
            'priority' => 'Sedang',
            'deadline_date' => '2025-12-31',
            'deadline_time' => '10:00',
        ];

        $this->actingAs($user)
            ->post(route('tasks.store'), $taskData)
            ->assertRedirect(route('tasks.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('tasks', [
            'user_id' => $user->id,
            'title' => 'Tugas Baru',
            'priority' => 'Sedang',
        ]);
    }

    public function test_authenticated_user_can_mark_a_task_as_completed()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id, 'completed' => false]);

        $this->actingAs($user)
            ->patch(route('tasks.update', $task), ['completed' => true])
            ->assertRedirect(route('tasks.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'completed' => true,
        ]);
    }

    public function test_user_cannot_update_another_users_task()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $otherUsersTask = Task::factory()->create(['user_id' => $otherUser->id]);

        $this->actingAs($user)
            ->patch(route('tasks.update', $otherUsersTask), ['completed' => true])
            ->assertStatus(403);
    }

    public function test_authenticated_user_can_delete_a_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->delete(route('tasks.destroy', $task))
            ->assertRedirect(route('tasks.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_user_cannot_delete_another_users_task()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $otherUsersTask = Task::factory()->create(['user_id' => $otherUser->id]);

        $this->actingAs($user)
            ->delete(route('tasks.destroy', $otherUsersTask))
            ->assertStatus(403);
    }
}