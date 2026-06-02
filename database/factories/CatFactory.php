<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::all()->random();
        $cats =
            [
                [
                    'name' => 'Golden Tailong',
                    'image' => 'https://pet-health-content-media.chewy.com/wp-content/uploads/2025/04/16210332/202504202403beautiful-cat-bengal.jpg',
                ],
                [
                    'name' => 'Copito',
                    'image' => 'https://pet-health-content-media.chewy.com/wp-content/uploads/2025/04/16210331/202504202404beautiful-cats-birman-breed.jpg',],
                [
                    'name' => 'Peluche',
                    'image' => 'https://pet-health-content-media.chewy.com/wp-content/uploads/2025/04/16210332/202504202404beautiful-cats-British-Shorthair.jpg',
                ],
                [
                    'name' => 'Chocolate',
                    'image' => 'https://pet-health-content-media.chewy.com/wp-content/uploads/2025/04/16210332/202504202404Beautiful-cats-burmese.jpg',
                ],
                [
                    'name' => 'Lola',
                    'image' => 'https://pet-health-content-media.chewy.com/wp-content/uploads/2025/04/16210331/202504202404beautiful-cats-siamese-cat-breed.jpg',
                ],
                [
                    'name' => 'Goku',
                    'image' => 'https://pet-health-content-media.chewy.com/wp-content/uploads/2025/04/16210329/202504202404beautiful-cats-oriental-cat-breeds.jpg',
                ],
                [
                    'name' => 'Bygul',
                    'image' => 'https://pet-health-content-media.chewy.com/wp-content/uploads/2025/04/16210326/202504202404beautiful-cats-ragdoll.jpg'
                ],
                [
                    'name' => 'Nala',
                    'image' => 'https://pet-health-content-media.chewy.com/wp-content/uploads/2025/04/16210329/202504202404beautiful-cats-russian-blue.jpg'
                ],
                [
                    'name' => 'Kuro',
                    'image' => 'https://pet-health-content-media.chewy.com/wp-content/uploads/2025/04/16210329/202504202404beautiful-cats-russian-blue.jpg'
                ],
                [
                    'name' => 'tailong',
                    'image' => 'https://media.istockphoto.com/id/505792978/es/foto/cat-en-la-nieve.jpg?s=612x612&w=is&k=20&c=kFJt2vC4oTDtkjqksBgebbuPQQPnv0DI0gGsw7qW9XI='
                ],
            ];
            $index = $this->faker->randomElement(array_keys($cats));
        return [
            'name' => $cats[$index] ['name'],
            'image' => $cats[$index] ['image'],
            'age' => $this->faker->numberBetween(1,100),
            'weight' => $this->faker->numberBetween(1,100),
            'race' => $this->faker->randomElement(['siames', 'gato europeo', 'gay', 'sin raza']),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'user_id' => $user->id,
        ];
    }
}
