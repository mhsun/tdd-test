<?php

namespace Tests\Feature;

use App\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddTodoTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $attr;

    public function setUp(): void
    {
        parent::setUp();

        $this->attr = [
            "title"  => $this->faker->sentence,
            "status" => false
        ];
    }

    /**
     * @test
     * @group todos
     */
    public function title_is_required()
    {
        $this->attr['title'] = null;

        $this->postJson('/api/todos', $this->attr)
            ->assertJsonValidationErrors([
                'title' => "abul babul"
            ]);
    }

    /**
     * @test
     * @group todos
     */
    public function user_can_add_todo()
    {
        $this->withoutExceptionHandling();

        $this->postJson('/api/todos', $this->attr)
            ->assertCreated()
            ->assertJson([
                "data" => $this->attr
            ]);

        $this->assertDatabaseHas('todos', $this->attr);
    }

    /**
     * @test
     */
    public function user_can_edit_todo()
    {
        $todo = factory(Todo::class)->create();

        $this->patchJson('/api/todos/'.$todo->id, $this->attr)
            ->assertOk()
            ->assertJson([
                'data' => $this->attr
            ]);

        $this->assertDatabaseHas('todos', $this->attr);
    }

    /** @test */
    public function user_can_see_all_todo()
    {
        $this->withoutExceptionHandling();

        $todos = factory(Todo::class, 5)->create()->toArray();

        $this->getJson('/api/todos/')
            ->assertOk()
            ->assertJson([
                'data' => $todos
            ]);

        $this->assertEquals(5, Todo::count());

        $this->assertDatabaseCount('todos', 5);
    }
}
