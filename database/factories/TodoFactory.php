<?php

namespace Database\Factories;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Todo>
 */
class TodoFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startsAt = fake()->dateTimeBetween('+1 week', '+2 months');

        return [
            'user_id' => User::factory(),
            'title' => fake()->randomElement(['朝焼けトレッキング', '地熱蒸し料理教室', '雪上ヨガ体験']).' '.fake()->unique()->numberBetween(1, 100000),
            'memo' => '八幡平の自然と文化を楽しむ体験イベントです。',
            'category' => fake()->city().'市民ホール',
            'start_at' => $startsAt,
            'due_at' => (clone $startsAt)->modify('+2 hours'),
        ];
    }
}
