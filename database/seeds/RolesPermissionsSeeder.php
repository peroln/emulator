<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{DB, Log};
use App\{Permission, Role};

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $roles_permissions_arr = $this->preparationData();
            DB::table('roles_permissions')->insert($roles_permissions_arr);
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
        $roles_permissions_arr = config('seeder.roles_permissions');

        $permissions = Permission::all();
        $roles = Role::all();
        $result_arr = [];
        if (is_array($roles_permissions_arr) && count($roles_permissions_arr)) {
            foreach ($roles_permissions_arr as $role => $permission) {
                $role_id = optional($roles->where('name', $role)->first())->id;
                $permissions_id = optional($permissions->whereIn('name', $permission)->pluck('id'))->toArray();
                if ($role_id && count($permissions_id)) {
                    foreach ($permissions_id as $permission_id) {
                        $result_arr[] = ['role_id' => $role_id, 'permission_id' => $permission_id];
                    }
                }
            }
            return collect($result_arr)->sortBy('role_id')->toArray();
        } else {
            throw new Exception('The array roles_permissions of the config file seed.php is empty.');
        }
    }
}
