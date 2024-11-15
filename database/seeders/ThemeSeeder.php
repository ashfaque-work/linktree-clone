<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Theme;


class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Theme::create([
            'name' => 'Default',
            'background_color' => '#ffffff',
            'font_color' => '#000000',
            'button_color' => '#3490dc',
            'background_image' => null,
        ]);
    }
}
