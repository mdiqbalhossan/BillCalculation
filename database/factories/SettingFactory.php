<?php

namespace Database\Factories;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Factories\Factory;

class SettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Setting::class;
    public function definition()
    {
        return [
            'isUtility' => 1,
            'isCooker' => 1
        ];
    }
}
