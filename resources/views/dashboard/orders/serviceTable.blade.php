<div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
    <div class="widget-content widget-content-area br-6">
        <div class="col-md-12 text-right mb-3">

        </div>
        <table id="html5-extension" class="table table-hover non-hover pos_table" style="width:100%">
            <thead>
            <tr>

                <th>{{__('dash.service')}}</th>
                <th>{{__('dash.category')}}</th>
                <th>الكمية</th>
                <th>سعر الوحده</th>
                <th>المجموع</th>
                <th class="no-content">{{__('dash.actions')}}</th>
            </tr>
            </thead>
            <tbody id="item-service">
            <input type="hidden" id="itr" value="1">
                <tr>
                    <td style="width: 400px;">

                        <input type='text' class="form-control name-1" data-itr="1">
                        <input type='hidden' class="service-each service_id-1" name="service_id[1]"  >

                    </td>

                    <td style="width: 250px;">

                        <input type='text' readonly class="form-control category_name-1">
                        <input type='hidden' class="cate-each category_id-1" name="category_id[1]"  >

                    </td>

                    <td style="width: 220px;">
                        <div class="input-group input-number">
                            <span class="input-group-btn"><button type="button" onclick="changeQty(this,1)" class="btn btn-default btn-flat quantity-down">
                                      <i data-feather="minus" class="text-danger"></i>
                                </button></span>
                            <input type="number" value="1"  data-min="1"  onkeyup="change(1)" class="quantity-1 input_number input_quantity form-control" name="quantity[1]">
                            <span class="input-group-btn"><button type="button" onclick="changeQty(this,1)" class="btn btn-default btn-flat quantity-up">

                                     <i data-feather="plus" class="text-success"></i>
                                </button></span>
                        </div>

                    </td>

                    <td style="width: 150px;">
                        <input type="text" onkeyup="change(1)"  class="form-control unit_price" id="unit_price-1" name="unit_price[1]">
                    </td>

                    <td>
                        <input type="hidden" id="total-1" name="price[1]" class="form-control pos_line_total" value="0">

                        <div id="rowTotal-1">0</div> ريال
                    </td>

                    <td>
                        <button type="button" data-itr="1" class="btn btn-primary card-tools plus-service">
                            +
                        </button>
                    </td>
                </tr>

            </tbody>
        </table>

        <div class="table-responsive">
            <table class="table table-condensed table-bordered table-striped">
                <tbody><tr>
                    <td>
                        <div class="row pull-right" style="background-color: #eff5ff">
                            <div class="col-md-1">
                                <h5> عناصر : <span class="total_quantity">0</span></h5>

                            </div>

                            <div class="col-md-1">
                                <h5> المجموع : <span class="price_total">0</span></h5>

                            </div>

                        </div>
                    </td>
                </tr>
                </tbody></table>
        </div>
    </div>
</div>


