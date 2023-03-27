<?php

namespace App\Datatables\Dashboard\Core\Administration;

use App\Enums\Core\RolesEnum;
use App\Support\Datatables\BaseDatatable;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Html\Column;

class RolesDatatable extends BaseDatatable
{
    protected ?string $actionable = 'edit|delete';

    public function query(): Builder
    {
        return Role::whereGuardName('dashboard')
            ->whereNotIn('name', ['super', 'user', 'admin'])
            ->withCount('permissions');
    }

    protected function getColumns(): array
    {
        return array_merge([
            Column::make('name')->title(__('dash.name')),
        ], parent::getColumns());
    }
}
