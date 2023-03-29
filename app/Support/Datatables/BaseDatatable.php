<?php

namespace App\Support\Datatables;

use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

abstract class BaseDatatable extends DataTable
{
    protected string $route = '';

    protected ?string $actionable = 'edit|delete';

    protected bool $indexer = true;

    protected function getCustomColumns(): array
    {
        return [];
    }

    public function dataTable($query)
    {
        $datatable = datatables()->eloquent($query)->addIndexColumn();
        $customColumns = collect($this->prepareCustomColumns());

        $customColumns->each(fn(\Closure $i, $key) => $datatable->addColumn($key, $i));

        collect($this->getFilters())
            ->each(fn(\Closure $i, $key) => $datatable->filterColumn($key, $i));

        collect($this->getOrders())
            ->each(fn(\Closure $i, $key) => $datatable->orderColumn($key, $i));

        return $datatable->rawColumns($customColumns->keys()->all());
    }

    protected function getFilters(): array
    {
        return [];
    }

    protected function getActions($model): array
    {
        return [];
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $url = config('custom.FORCE_HTTPS') ?
            str_replace('http:', 'https:', secure_url(url()->full())) : url()->full();

        return $this->builder()
            ->setTableId('html5-extension')
            ->columns($this->prepareColumns())
            ->minifiedAjax($url)
            ->language($this->translation())
            ->fixedHeader(true)
            ->buttons([
                ['extend'=> 'copy', 'className'=> 'btn btn-sm'],
                ['extend'=> 'csv', 'className'=> 'btn btn-sm'],
                ['extend'=> 'excel', 'className'=> 'btn btn-sm'],
                ['extend'=> 'print', 'className'=> 'btn btn-sm']
            ])
            ->dom("<'dt--top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'B><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f>>>
                <'table-responsive'tr>
                <'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>");
    }

    private function translation(): array
    {

        return [
            "url" => app()->getLocale() == 'ar'? "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Arabic.json" : "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/English.json'}}",
//            'sEmptyTable'     => __('dash.no data available in table'),
//            'sInfo'           => __('dash.Showing').' _START_ '.__('dash.to').' _END_ '.__('dash.of').' _TOTAL_ '.__('dash.entries'),
//            'sInfoEmpty'      => __('dash.Showing').' 0 '.__('dash.to').' 0 '.__('dash.of').' 0 '.__('dash.entries'),
//            'sInfoFiltered'   => '('.__('dash.filtered').' '.__('dash.from').' _MAX_ '.__('dash.total').' '.__('dash.entries').')',
//            'sInfoPostFix'    => '',
//            'sInfoThousands'  => ',',
//            'sLengthMenu'     => __('dash.show').' _MENU_ ',
//            'sLoadingRecords' => __('dash.loading...'),
//            'sProcessing'     => __('dash.processing').'...',
//            'sSearch'         => __('dash.search').' : ',
//            'sZeroRecords'    => __('dash.no matching records found'),
//            'oPaginate'       => [
//                "sPrevious" => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
//                "sNext" => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
//            ],
        ];
    }

    public function getIndex()
    {
        $indexColumn = $this->builder()->config->get('datatables.index_column', 'DT_RowIndex');

        return new Column([
            'data' => $indexColumn,
            'name' => $indexColumn,
            'title' => '#',
            'searchable' => false,
            'orderable' => false,
        ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [];
    }

    protected function column(string $name, string $title, $searchable = false): Column
    {
        return Column::make($name)
            ->title($title)
            ->orderable(false)
            ->searchable($searchable)
            ->content('---');
    }

    protected function getOrders()
    {
        return [];
    }

    private function prepareColumns()
    {
        $list = [];

        if ($this->indexer) {
            $list[] = $this->getIndex();
        }

        $list = array_merge($list, $this->getColumns());
        if ($this->actionable !== '') {
            $list[] = Column::computed('action')
                ->title(__('dash.actions'))
                ->searchable(false)
                ->exportable(false)
                ->printable(false)
                ->width(50)
                ->addClass('text-center');
        }

        return $list;
    }

    public static function create(string $route): static
    {
        $instance = new static();
        $instance->route = $route;

        return $instance;
    }

    private function prepareCustomColumns()
    {
        $customs = $this->getCustomColumns();

        if ($this->actionable !== '') {
            $customs['action'] = function ($model) {
                $allActions = array_merge(
                    $this->getActions($model), $this->prepareActionsButtons($model)
                );
                $actions = implode('', $allActions);

                return "<div class='btn-group'>{$actions}</div>";
            };
        }

        return $customs;
    }

    private function prepareActionsButtons($model)
    {
        $currentActions = explode('|', $this->actionable);
        $actions = [];

        if (in_array('show', $currentActions)) {
            $editRoute = route($this->route . '.show', $model);
            $actions[] = <<<HTML
                 <a href='$editRoute' class="mr-2 btn btn-outline-success btn-sm"><i class="far fa-eye fa-2x"></i> </a>
            HTML;
        }

        if (in_array('edit', $currentActions)) {
            $editRoute = route($this->route . '.edit', $model);
            $actions[] = <<<HTML
                 <a href='$editRoute' class="mr-2 btn btn-outline-warning btn-sm"><i class="far fa-edit fa-2x"></i> </a>
            HTML;
        }

        if (in_array('delete', $currentActions)) {
            $deleteRoute = route($this->route . '.destroy', $model);
            $actions[] = <<<HTML
                      <a data-id='{$model->getKey()}' class="mr-2 btn btn-outline-danger btn-delete btn-sm">
                            <i class="far fa-trash-alt fa-2x"></i>
                    </a>
            HTML;
        }

        return $actions;
    }
}
