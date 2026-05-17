<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoryIconSeeder extends Seeder
{
    public function run(): void
    {
        $icons = [
            'fiction'     => ['icon' => '📖', 'color' => '#7c3aed'],
            'non-fiction' => ['icon' => '📰', 'color' => '#0ea5e9'],
            'science'     => ['icon' => '🔬', 'color' => '#10b981'],
            'technology'  => ['icon' => '💻', 'color' => '#f59e0b'],
            'history'     => ['icon' => '🏛️', 'color' => '#ef4444'],
            'biography'   => ['icon' => '👤', 'color' => '#8b5cf6'],
            'religion'    => ['icon' => '🕌', 'color' => '#f97316'],
            'children'    => ['icon' => '🧸', 'color' => '#ec4899'],
            'comics'      => ['icon' => '🦸', 'color' => '#14b8a6'],
            'poetry'      => ['icon' => '✍️', 'color' => '#a855f7'],
            'business'    => ['icon' => '💼', 'color' => '#06b6d4'],
            'self help'   => ['icon' => '🌟', 'color' => '#eab308'],
            'travel'      => ['icon' => '✈️', 'color' => '#22c55e'],
            'cooking'     => ['icon' => '🍳', 'color' => '#f43f5e'],
            'art'         => ['icon' => '🎨', 'color' => '#d946ef'],
            'education'   => ['icon' => '🎓', 'color' => '#3b82f6'],
            'health'      => ['icon' => '❤️', 'color' => '#ef4444'],
            'sports'      => ['icon' => '⚽', 'color' => '#84cc16'],
            'politics'    => ['icon' => '🗳️', 'color' => '#6366f1'],
            'philosophy'  => ['icon' => '🤔', 'color' => '#78716c'],
            'novel'       => ['icon' => '📚', 'color' => '#7c3aed'],
            'academic'    => ['icon' => '🎓', 'color' => '#3b82f6'],
            'islamic'     => ['icon' => '🕌', 'color' => '#f97316'],
            'medical'     => ['icon' => '🏥', 'color' => '#ef4444'],
            'law'         => ['icon' => '⚖️', 'color' => '#6366f1'],
            'economics'   => ['icon' => '📈', 'color' => '#10b981'],
            'psychology'  => ['icon' => '🧠', 'color' => '#8b5cf6'],
            'language'    => ['icon' => '🗣️', 'color' => '#0ea5e9'],
            'computer'    => ['icon' => '💻', 'color' => '#f59e0b'],
            'math'        => ['icon' => '🔢', 'color' => '#14b8a6'],
        ];

        $categories = Category::all();

        foreach ($categories as $cat) {
            $nameLower = strtolower($cat->name);
            $matched   = false;

            foreach ($icons as $keyword => $data) {
                if (str_contains($nameLower, $keyword)) {
                    $cat->update([
                        'icon'  => $data['icon'],
                        'color' => $data['color'],
                    ]);
                    $this->command->info("Updated: {$cat->name} → {$data['icon']}");
                    $matched = true;
                    break;
                }
            }

            if (!$matched) {
                $cat->update(['icon' => '📚', 'color' => '#7c3aed']);
                $this->command->info("Default: {$cat->name} → 📚");
            }
        }
    }
}