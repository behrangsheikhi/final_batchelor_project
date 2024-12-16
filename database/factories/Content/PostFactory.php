<?php

namespace Database\Factories\Content;

use App\Models\Admin\Content\PostCategory;
use App\Models\Content\Post;
use App\Models\Content\PostCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'slug' => null,
            'summary' => $this->faker->paragraph,
            'body' => $this->faker->paragraph(4),
            'image' => 'images/post_images/download.jpg',
            'status' => '1',
            'commentable' => 0,
            'tags' => $this->faker->sentence,
            'user_id' => function () {
                return User::inRandomOrder()->first();
            },
            'category_id' => function () {
                return PostCategory::inRandomOrder()->first();
            },
            'published_at' => now(),
            'created_at' => now(),
            'updated_at' => null,
            'deleted_at' => null
        ];
    }
}
