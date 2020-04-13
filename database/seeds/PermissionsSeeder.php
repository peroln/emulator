<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{DB, Log};

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try{
            $permissions_arr = $this->preparationData();
            DB::table('permissions')->insert($permissions_arr);
        }catch(Throwable $e){
            $this->command->error($e->getMessage());
            Log::error($e->getMessage());
            exit;
        }


    }

    /**
     * @return array
     * @throws Exception
     */
    private function preparationData(): array {

        UsersSeeder::checkConfigFileSeeder();
        $permissions_arr = collect(config('seeder.roles_permissions'));
        $flattened = $permissions_arr->flatten();
        $flattened = $flattened->unique()->values()->map(function ($item, $key) {
           return ['name' => $item];
       });
        return $flattened->toArray();

    }
}
