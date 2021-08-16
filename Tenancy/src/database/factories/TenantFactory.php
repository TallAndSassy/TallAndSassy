<?php

namespace TallAndSassy\Tenancy\database\factories;

use TallAndSassy\Tenancy\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class TenantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tenant::class;

    private array $oldSlugs = [];

    private  function buildUniqueSlug(string $short_name, $type, int $new_salt = 0): string {
        $arrParts = explode(' ', $short_name);
        if (count($arrParts) == 1) {
            $slug = $short_name;
        } elseif (count($arrParts) >= 3 && strpos($arrParts[0], '.') > 0) {
            $slug = $arrParts[2];
        } else {
            $slug = $arrParts[1];
        }
        //$slug = $slug.($this->faker->boolean(90) ? ' '.$type : '');
        $slug = strtolower(str_replace([' ',"'"],'', $slug));

        if ($new_salt) {
            $slug = $slug.$new_salt;
        }

        //$c = School::where('slug', '=', $slug)->count();
        //print_r($this->);

        if (! in_array($slug, $this->oldSlugs)) {
            $this->oldSlugs[] = $slug;
            return $slug;
        } else {
            $new_salt++;
            return $this->buildUniqueSlug($short_name, $type, $new_salt);
        }
    }

    private function buildSchoolName(string $name, string $type): string {
        $arrParts = explode(' ', $name);
        if (strpos($arrParts[0], '.') > 0) {
            array_shift($arrParts);
        }

        $pattern = '/(PhD$)|([IV]+$)|(DVM)|(DDS)|(Sr\.)|(Jr\.)/';
        $tmpArr = $arrParts; // I am scared of that end() function
        if (preg_match($pattern, end($tmpArr))) {
            array_pop($arrParts);
        }

        $out = implode(' ', $arrParts);
        return $out.' '.$type;

    }
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $short_name = (($this->faker->boolean(30)) ?
            $this->faker->name() : $this->faker->city());


        $type = ($this->faker->boolean(70) ? 'ES' : 'MS');

        $long_name = $this->buildSchoolName($short_name, $type);
        $slug = $this->buildUniqueSlug($short_name, $type);

        return [
            'name' => $long_name,
            'slug' => $slug,
        ];
    }
}
