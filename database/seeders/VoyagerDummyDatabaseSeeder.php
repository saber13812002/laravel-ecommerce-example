<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Traits\Seedable;

class VoyagerDummyDatabaseSeeder extends Seeder
{
    use Seedable;

    protected $seedersPath = __DIR__.'/';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seed(CategoriesTableSeeder::class);
        $this->seed(UsersTableSeeder::class);
        $this->seed(PostsTableSeeder::class);
        $this->seed(PagesTableSeeder::class);
        $this->seed(TranslationsTableSeeder::class);
    }
}
