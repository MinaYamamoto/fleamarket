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
        $this->call(Category_contentsTableSeed::class);
        $this->call(UsersTableSeed::class);
        if(app()->isLocal()){
            $this->call(ItemsTableSeed::class);
        } else {
            $this->call(ItemsTableSeedEc2::class);
        }
        $this->call(CommentsTableSeed::class);
        if(app()->isLocal()) {
            $this->call(ProfilesTableSeed::class);
        }else{
            $this->call(ProfilesTableSeedEc2::class);
        }
        $this->call(PurchasesTable::class);
    }
}
