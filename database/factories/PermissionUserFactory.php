<?php

namespace Database\Factories;

use App\Enums\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PermissionUser>
 */
class PermissionUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }

    private function make_sequence(): Sequence
    {
        return new Sequence(...array_map(fn ($permission) => [
            'permission' => $permission,
        ], Permission::cases()));
    }

    public function all(): PermissionUserFactory
    {
        return $this
            ->count(count(Permission::cases()))
            ->state($this->make_sequence());
    }
}
