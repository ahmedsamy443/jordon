<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'email' => 'admin@admin.com',
            'name' => 'admin',
            'password' => bcrypt('12345678'),
            'user_type_id'=>1
        ]);
      $role =Role::create(['name' => 'admin']);
        $per = ['edit-tasks','delete-tasks','insert-tasks'];
           
        foreach ($per as  $value) 
        {
            $s=Permission::create(['name'=>$value]);
            $role->givePermissionTo($s);
        }
      
       
        $user->assignRole('admin');
    }
}
