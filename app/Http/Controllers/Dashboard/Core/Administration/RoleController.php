<?php

namespace App\Http\Controllers\Dashboard\Core\Administration;

use App\Datatables\Dashboard\Core\Administration\RolesDatatable;
use App\Http\Controllers\Controller;
use App\Support\Crud\WithCrud;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    use WithCrud;

    protected string $path = 'dashboard.core.administration.roles';

    protected string $model = Role::class;

    protected string $datatable = RolesDatatable::class;

    protected function formData(?Model $model = null): array
    {
        return [
            'permissions' => Permission::whereGuardName('dashboard')->get(),
        ];
    }

    protected function rules()
    {
        if(\Route::is('dashboard.core.administration.roles.store')) {
            $rules = [
                'name'        => 'required|string|max:191|not_in:user,super|unique:roles,name,'.request()->route('id'),
                'permissions' => 'required|array',
            ];
        }else{
            $rules = [
                'name'        => 'nullable|string|max:191|not_in:user,super|unique:roles,name,'.request()->route('id'),
                'permissions' => 'required|array',
            ];
        }
        return $rules;
    }

    protected function storeAction(array $validated)
    {
        $permissions = array_keys($validated['permissions']);
        Arr::pull($validated, 'permissions');
        $validated['guard_name'] = 'dashboard';
        $role = Role::create($validated);
        $role->syncPermissions($permissions);
    }

    protected function updateAction(array $validated, Model $model)
    {
        $permissions = array_keys($validated['permissions']);
        Arr::pull($validated, 'permissions');
        $model->syncPermissions($permissions);
        if (!in_array($model->name, ['admin', 'super'])){
            $model->update($validated);
        }
    }
}
