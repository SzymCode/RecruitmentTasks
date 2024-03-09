<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuthorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Author::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Author $author) {
            $news = News::factory()->count(random_int(1, 15))->create();
            $author->news()->attach($news);
        });
    }
}
