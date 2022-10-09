<?php

namespace App\Console\Commands;

use App\Enums\Permission;
use App\Models\PermissionUser;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function ask_password(): string
    {
        $password = $this->secret('Password');
        $password_confirmation = $this->secret('Confirm password');

        if ($password !== $password_confirmation) {
            $this->error('Passwords do not match.');
            return $this->ask_password();
        }

        return $password;
    }

    /**
     * Execute the console command.
     *
     * @return Permission[]
     */
    public function ask_permissions(): array
    {
        $available_permissions = Permission::cases();
        $available_permissions_string = array_map(fn(Permission $permission): string => $permission->name, $available_permissions);

        $this->info('Available permissions:');
        $this->line(join(', ', $available_permissions_string));

        while(true)
        {
            $permissions_string = $this->ask('Permissions (comma splitted, "ALL" for all)');

            if($permissions_string === 'ALL') return $available_permissions;

            $permissions_string = array_filter(array_map('trim', explode(',', $permissions_string)));

            $permissions_enum = [];
            foreach ($permissions_string as $permission_string) {
                $permission = Permission::tryFrom($permission_string);
                if($permission === null) {
                    $this->error("Permission '$permission_string' does not exist.");
                    continue 2;
                }
                $permissions_enum[] = $permission;
            }

            return $permissions_enum;

        }

    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $name = $this->ask('Name');
        $email = $this->ask('Email');
        $password = $this->ask_password();

        $permissions = $this->ask_permissions();

        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->save();

        $user->permissions()
            ->saveMany(array_map(fn(Permission $permission): PermissionUser => new PermissionUser(['permission' => $permission]), $permissions));

        return Command::SUCCESS;
    }
}
