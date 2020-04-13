<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{DB, Log};
use App\{User, Role};

class UsersRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $arr_insert = $this->preparationData();
            if (count($arr_insert)) {
                DB::table('users_roles')->insert($arr_insert);
            }

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
        $assignments = config('seeder.assignments');
        $users = User::all();
        $roles = Role::all();
        $arr_insert = [];

        if (is_array($assignments) && count($assignments)) {
            foreach ($users as $number => $user) {
                foreach ($assignments as $role_config => $email) {
                    if (in_array($user->email, $email)) {
                        $role_id = optional($roles->where('name', $role_config)->first())->id;
                        if ($role_id) {
                            $arr_insert[$number] = [
                                'user_id' => $user->id,
                                'role_id' => $role_id,
                                'created_at' => now()
                            ];
                            break;
                        } else {
                            throw new Exception('This role_id does not exist');
                        }
                    } else {
                        $arr_insert[$number] = [
                            'user_id' => $user->id,
                            'role_id' => Role::DEFAULT_ROLE,
                            'created_at' => now()
                        ];
                    }
                }
            }
        } else {
            throw new Exception('The array of assignments in seeder.php do not exist');
        }

        return $arr_insert;
    }
}
