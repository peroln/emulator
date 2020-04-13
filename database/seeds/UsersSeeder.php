<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\{Hash, DB, Log};

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $users = $this->preparationData();
            DB::table('users')->insert($users);
            factory(App\User::class, 10)->create();
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

        self::checkConfigFileSeeder();
        $users = config('seeder.users');

        if (is_array($users) && count($users)) {
            foreach ($users as &$user) {
                foreach ($user as $key => &$value) {
                    if ($key === 'password') {
                        $value = Hash::make($value);
                    }
                }
                $user = array_merge($user, [
                    'email_verified_at' => now(),
                    'remember_token' => Str::random(10),
                ]);
            }
            return $users;
        } else {
            throw new Exception('The array users of the config file seed.php is empty or config/seed.php file does not exist ');
        }
    }

    /**
     * @throws Exception
     */
    public static function checkConfigFileSeeder()
    {
        $path = config_path('seeder');
        if (!is_readable($path . '.php')) {
            throw new Exception('The config file seeder.php is not readable or does not exist ');
        }
    }
}
