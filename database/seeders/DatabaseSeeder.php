<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Get or create test user
        $user = User::firstOrCreate(
            ['email' => 'daffabdullah111@gmail.com'],
            [
                'name' => 'Daffa Abdullah',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
            ]
        );

        // Predefined realistic code snippets
        $snippets = [
            [
                'title' => 'Laravel Route Group',
                'content' => "Route::middleware(['auth', 'verified'])->group(function () {\n    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');\n});",
            ],
            [
                'title' => 'Alpine.js Click Handler',
                'content' => "<button x-data=\"{ open: false }\" @click=\"open = !open\">\n    Toggle\n</button>",
            ],
            [
                'title' => 'Tailwind Flex Center',
                'content' => "<div class=\"flex items-center justify-center min-h-screen bg-slate-100\">\n    <p>Centered Content</p>\n</div>",
            ],
            [
                'title' => 'PHP Array Map Example',
                'content' => "\$numbers = [1, 2, 3, 4, 5];\n\$squares = array_map(fn(\$n) => \$n * \$n, \$numbers);",
            ],
            [
                'title' => 'JavaScript Fetch API',
                'content' => "fetch('/api/data')\n  .then(res => res.json())\n  .then(data => console.log(data));",
            ],
            [
                'title' => 'Python List Comprehension',
                'content' => "numbers = [1, 2, 3, 4, 5]\nsquares = [x**2 for x in numbers]\nprint(squares)",
            ],
            [
                'title' => 'C++ Hello World',
                'content' => "#include <iostream>\n\nint main() {\n    std::cout << \"Hello, World!\" << std::endl;\n    return 0;\n}",
            ],
            [
                'title' => 'SQL Select Join',
                'content' => "SELECT users.name, notes.title \nFROM users \nINNER JOIN notes ON users.id = notes.user_id \nORDER BY notes.created_at DESC;",
            ]
        ];

        // Seed snippets and random text notes
        $faker = \Faker\Factory::create();
        $totalNotes = 30;

        for ($i = 0; $i < $totalNotes; $i++) {
            // Generate unique slug
            do {
                $slug = \Illuminate\Support\Str::lower(\Illuminate\Support\Str::random(6));
            } while (\App\Models\Note::where('slug', $slug)->exists());

            // Predefined code snippet or random text note
            if ($i < count($snippets)) {
                $title = $snippets[$i]['title'];
                $content = $snippets[$i]['content'];
            } else {
                $title = $faker->words(rand(2, 5), true);
                $content = $faker->paragraphs(rand(1, 3), true);
            }

            // Distribute notes over the last 15 days
            $createdAt = now()->subMinutes(rand(1, 21600)); // within 15 days

            \App\Models\Note::create([
                'user_id' => $user->id,
                'title' => ucwords($title),
                'content' => $content,
                'slug' => $slug,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        }
    }
}
