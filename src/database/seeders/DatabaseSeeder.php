<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ConditionsTableSeed::class);
        $this->call(CategoriesTableSeed::class);
        $this->call(ContentsTableSeed::class);
        $this->call(Category_contentsTable::class);
        $this->call(UsersTableSeed::class);
        $this->call(ItemsTableSeed::class);
        $this->call(CommentsTableSeed::class);
        $this->call(ProfilesTableSeed::class);
        $this->call(PurchasesTable::class);
    }
}
