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
        return Admin::whereKeyNot(1)->latest()->withoutGlobalScopes();
    }

    protected function getColumns(): array
    {
        return [
            Column::make('name')->title(__('dash.first name')),
            Column::make('roles')->title(__('dash.roles')),
            Column::make('email')->title(__('dash.email')),
            Column::make('phone')->title(__('dash.phone')),
            Column::make('active')->title(__('dash.active')),

        ];
    }

    protected function getCustomColumns(): array
    {
        return [
            'name' => function ($model) {
                $name = $model->first_name . ' ' . $model->last_name;
                return $name;
            },
            'roles' => function ($model) {
                $html = ' ';
                foreach ($model->roles as $role) {
                    $html .= '<button class="btn btn-sm btn-primary">'.$role->name.'</button> ';
                }
                return $html;
            },
            'active' => function ($model) {
                if ($model->active == 1) {
                    $check = 'checked';
                } else {
                    $check = '';
                }

                $html = '<label class="switch s-outline s-outline-info  mb-4 mr-2">
                        <input type="checkbox" id="customSwitch4" data-id="' . $model->id . '" ' . $check . '>
                        <span class="slider round"></span>
                        </label>';
                return $html;
            },
        ];
    }
}
