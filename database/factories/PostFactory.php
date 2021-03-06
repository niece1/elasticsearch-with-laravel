<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->unique()->text(20),
            'body' => $this->faker->text(7000),
            'slug' => $this->faker->text(20),
            'viewed' => $this->faker->numberBetween(1, 1000),
            'published' => true,
            'time_to_read' => $this->faker->numberBetween(1, 10),
            'user_id' => function () {
                return User::all()->random();
            },
            'category_id' => function () {
                return Category::all()->random();
            },
        ];
    }
}
