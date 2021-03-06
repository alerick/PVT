<?php

use Illuminate\Database\Seeder;
use App\Permission;

class LoanPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name' => 'create-loan',
                'display_name' => 'Crear trámites de préstamo'
            ], [
                'name' => 'update-loan',
                'display_name' => 'Editar trámites de préstamo'
            ], [
                'name' => 'show-loan',
                'display_name' => 'Ver trámites de préstamo para el rol'
            ], [
                'name' => 'show-all-loan',
                'display_name' => 'Ver todos los trámites de préstamo'
            ], [
                'name' => 'delete-loan',
                'display_name' => 'Anular trámites de préstamo'
            ], [
                'name' => 'print-contract-loan',
                'display_name' => 'Imprimir contrato de préstamo'
            ]
        ];
        foreach ($permissions as $permission) {
            Permission::firstOrCreate($permission);
        }
    }
}