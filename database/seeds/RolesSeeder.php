<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $roles = $this->preparationData();
            DB::table('roles')->insert($roles);
        } catch (Throwable $e) {
            $this->command->error($e->getMessage());
            Log::error($e->getMessage());
            exit;
        }
    }

    /**
     * @return array
     * @throws Exception
     */
    private function preparationData(): array
    {
        UsersSeeder::checkConfigFileSeeder();
        $roles = array_keys(config('seeder.roles_permissions'));

        if (is_array($roles) && count($roles)) {
            $arr_roles = [];
            foreach ($roles as $key => $role) {
                $arr_roles[$key]['name'] = $role;
            }
            return $arr_roles;

        } else {
            throw new Exception('The array roles of the config file seed.php is empty or config/seed.php file does not exist.');
        }
    }
}
