<?php

namespace Database\Seeders\Auth;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

/**
 * Class PermissionRoleTableSeeder.
 */
class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        $admin = Role::firstOrCreate(['name' => 'admin', 'title' => 'Admin', 'is_fixed' => true]);
        $demo_admin = Role::firstOrCreate(['name' => 'demo_admin', 'title' => 'Demo Admin', 'is_fixed' => true]);
        $vet = Role::firstOrCreate(['name' => 'vet', 'title' => 'Veterinarian', 'is_fixed' => true]);
        $groomer = Role::firstOrCreate(['name' => 'groomer', 'title' => 'Groomer', 'is_fixed' => true]);
        $walker = Role::firstOrCreate(['name' => 'walker', 'title' => 'Walker', 'is_fixed' => true]);
        $boarder = Role::firstOrCreate(['name' => 'boarder', 'title' => 'Boarder', 'is_fixed' => true]);   
        $trainer = Role::firstOrCreate(['name' => 'trainer', 'title' => 'Trainer', 'is_fixed' => true]);   
        $day_taker = Role::firstOrCreate(['name' => 'day_taker', 'title' => 'Day Care Taker', 'is_fixed' => true]);   
        $user = Role::firstOrCreate(['name' => 'user', 'title' => 'Customer', 'is_fixed' => true]);
        $petsitter = Role::firstOrCreate(['name' => 'pet_sitter', 'title' => 'Pet Sitter', 'is_fixed' => true]);

        // Create Permissions
        // Permission::firstOrCreate(['name' => 'view_backend', 'is_fixed' => true]);
        Permission::firstOrCreate(['name' => 'edit_settings', 'is_fixed' => true]);
        Permission::firstOrCreate(['name' => 'view_logs', 'is_fixed' => true]);

        $permissions = Permission::defaultPermissions();

        foreach ($permissions as $key => $perms) {
            Permission::firstOrCreate(['name' => $key, 'is_fixed' => true]);
        }

        // Assign Permissions to Roles
        $admin->givePermissionTo(Permission::get());
        
        $demo_admin->givePermissionTo(Permission::get());

        $permissionsToRemove = ['view_permission', 'add_permission', 'edit_permission','view_product_subcategory'];
        $demo_admin->revokePermissionTo($permissionsToRemove);

        // Assign Permissions to Roles

        $vet->givePermissionTo(['view_veterinary','view_veterinary_booking','view_veterinary_service','view_service','add_service','edit_service','delete_service','view_category','view_subcategory','view_review','view_owners',"view_owner's_pet"]);
        $groomer->givePermissionTo(['view_grooming','view_grooming_booking','view_grooming_service','view_service','add_service','edit_service','delete_service','view_category','view_subcategory','view_review','view_owners',"view_owner's_pet"]);
        $user->givePermissionTo(['view_booking']);
        $walker->givePermissionTo(['view_walking','view_walking_booking','view_review','view_owners',"view_owner's_pet",'view_booking_request']);
        $boarder->givePermissionTo(['view_boarding','view_boarding_booking','view_review','view_owners',"view_owner's_pet"]);
        $trainer->givePermissionTo(['view_traning','view_training_booking','view_review','view_owners',"view_owner's_pet"]);
        $day_taker->givePermissionTo(['view_daycare','view_daycare_booking','view_review','view_owners',"view_owner's_pet"]);

        Schema::enableForeignKeyConstraints();
         
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        \Illuminate\Support\Facades\Artisan::call('route:clear');
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        \Illuminate\Support\Facades\Artisan::call('config:cache');

    }
}
