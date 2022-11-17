<?php

namespace Tests\Database;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_model_user_exists() {
        $user = User::factory()->create();

        $this->assertModelExists($user);
    }

    public function test_model_user_delete() {
        $user = User::factory()->create();

        $user->delete();

        $this->assertModelMissing($user);
    }

    public function test_model_user_duplication()
    {
        $user1 = User::make([
            'first_name' => 'John',
            'last_name'  => 'Doe',
            'email'      => 'johndoe@gmail.com'
        ]);

        $user2 = User::make([
            'first_name' => 'Mary',
            'last_name'  => 'Jane',
            'email'      => 'maryjane@gmail.com'
        ]);

        echo 'Jmeno: ' . $user1->first_name;
        echo 'Jmeno: ' . $user2->first_name;

        $this->assertTrue($user1->first_name != $user2->first_name);
    }

    public function test_database_contains_implicit_data() {
        $this->assertDatabaseHas('users', [
            'email' => 'admin@example.com',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'speedy@example.com',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'BBELM@example.com',
        ]);
    }

    public function test_database_update_user()
    {
        $user = User::find(2);

        $user->first_name = 'Josef';
        $user->last_name  = 'Rebenda';

        $user->save();

        $updatedUser = User::find(1);

        $this->assertTrue($user != $updatedUser);
    }

    public function test_database_delete_user()
    {
        $user = User::find(1);

        $user->delete();

        $this->assertDeleted($user);
    }

    public function test_database_delete_user_teacher_cascade()
    {
        $user = User::find(3);

        $user->delete();

        $this->assertDatabaseMissing('exercises', [
            'id' => 1
        ]);

        $this->assertDatabaseMissing('groups', [
            'id' => 1
        ]);

        $this->assertDatabaseMissing('groups', [
            'id' => 2
        ]);

        $this->assertDatabaseMissing('flashcards', [
            'exercise_id' => 1
        ]);

        $this->assertDatabaseHas('users', [
           'id' => 2
        ]);
    }

    public function test_database_delete_user_student_cascade()
    {
        $user = User::find(2);

        $user->delete();

        $this->assertDatabaseHas('exercises', [
            'id' => 1
        ]);

        $this->assertDatabaseHas('users', [
            'id' => 3
        ]);

        $this->assertDatabaseHas('groups', [
            'id' => 2
        ]);

        $this->assertDatabaseMissing('attempts', [
            'user_id' => 2
        ]);
    }

    public function test_database_data_count()
    {
        $this->assertDatabaseCount('users', 100);

        $user = User::find(1);

        $user->delete();

        $this->assertDatabaseCount('users', 99);
    }
}