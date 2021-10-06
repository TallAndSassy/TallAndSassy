<?php

namespace TallAndSassy\Tenancy\Database\factories;

use TallAndSassy\Tenancy\Models\Tenant;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactoryBase extends \Illuminate\Database\Eloquent\Factories\Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        if (session()->has('tenant_id')) {
            $tenant_id = session()->get('tenant_id');
        } else {
            $tenant_id = Tenant::factory()->create()->id;
        }

        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'), //https://laracasts.com/series/multitenancy-in-practice/episodes/2 at the seven minute mark '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'tenant_id' => $tenant_id,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

//    /**
//     * Indicate that the user should have a personal team.
//     *
//     * @return $this
//     */
//    public function withPersonalTeam()
//    {
//        if (! Features::hasTeamFeatures()) {
//            return $this->state([]);
//        }
//
//        return $this->has(
//            Team::factory()
//                ->state(function (array $attributes, User $user) {
//                    return ['name' => $user->name.'\'s Team', 'user_id' => $user->id, 'personal_team' => true];
//                }),
//            'ownedTeams'
//        );
//    }
}
