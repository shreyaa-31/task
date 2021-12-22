<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $module = ['category', 'subcategory', 'users', 'department', 'employees','employees-attendences'];

        foreach ($module as $key => $val) {
            $permissions = array();

            $create_per = $val . '_create';
            $update_per = $val . '_update';
            $delete_per = $val . '_delete';
            $view_per = $val . '_view';

            $permissions[] = $create_per;
            $permissions[] = $update_per;
            $permissions[] = $delete_per;
            $permissions[] = $view_per;
            foreach ($permissions as $p) {
                Permission::create([
                    'name' => $p,
                    'module'=>$val,
                    'guard_name' => 'admin'
                ]);
            }
        }
    }
}
