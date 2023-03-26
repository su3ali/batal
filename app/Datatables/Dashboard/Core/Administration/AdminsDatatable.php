<?php

namespace App\Datatables\Dashboard\Core\Administration;

use App\Models\Admin;
use App\Support\Datatables\BaseDatatable;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Column;

class AdminsDatatable extends BaseDatatable
{
    public function query(): Builder
    {
        return Admin::whereKeyNot(1)->role('admin')->latest()->withoutGlobalScopes();
    }

    protected function getColumns(): array
    {
        return [
            Column::make('name')->title(__('dash.name')),
            Column::make('email')->title(t_('dash.email')),
        ];
    }
}
