<?php
namespace TallAndSassy\Cms\database\factories;
//https://twitter.com/wylesone/status/1303610973736128512
//https://gist.github.com/fourstacks/9cc6a68ed25fbbf00aa016da34f9a8be
use Illuminate\Database\Eloquent\Factories\Factory;
class Page extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Page::class;



    private array $oldSlugs = [];
    private function buildSlugFromText(string $text, int $inc_num = 0) : string {
        if (session()->has('tenant_id')) {
            $current_tenant = session()->get('tenant_id');
        } else {
            $current_tenant = 'default';
        }

        if ( ! array_key_exists($current_tenant, $this->oldSlugs) ) {
            $this->oldSlugs[$current_tenant] = [];
        }

        $temp_slug = explode(' ', $text)[0];

        if ( in_array($temp_slug, $this->oldSlugs[$current_tenant], true) ) {
            return $this->buildSlugFromText($temp_slug, $inc_num + 1);
        } else {
            $this->oldSlugs[$current_tenant][] = $temp_slug;
            if ($inc_num > 0) {
                $temp_slug .= $inc_num;
            }
            return $temp_slug;
        }


    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $text = "";
        $paragraphs = $this->faker->paragraphs(4);
        foreach ($paragraphs as $p) {
            $text .= "<p> $p </p>";
        }


        return [
            'slug' => $this->faker->unique()->slug(),
            'title' => $this->faker->sentence(4),
            'content' => $text
        ];
    }
}
