<?php

namespace Database\Seeders;

use App\Models\Avatar;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AvatarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sortOrder = 0;

        foreach (['default', 'anime', 'graphic'] as $category) {
            $files = collect(File::files(public_path('avatars/'.$category)))
                ->filter(fn ($file): bool => in_array(strtolower($file->getExtension()), ['png', 'jpg', 'jpeg', 'webp'], true))
                ->sortBy(fn ($file): string => $file->getFilename());

            foreach ($files as $file) {
                $filename = pathinfo($file->getFilename(), PATHINFO_FILENAME);
                $slug = Str::slug($category.'-'.$filename);

                Avatar::updateOrCreate(
                    ['slug' => $slug],
                    [
                        'name' => ucfirst(str_replace(['_', '-'], ' ', $filename)),
                        'file_path' => 'avatars/'.$category.'/'.$file->getFilename(),
                        'category' => $category,
                        'is_active' => true,
                        'is_unlocked' => true,
                        'required_points' => 0,
                        'sort_order' => $sortOrder++,
                    ],
                );
            }
        }
    }
}
