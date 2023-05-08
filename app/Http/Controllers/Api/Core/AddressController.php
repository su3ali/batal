<?php

namespace App\Http\Controllers\Api\Core;

use App\Http\Controllers\Controller;
use App\Support\Api\ApiResponse;

class AddressController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('localize');
    }
    protected function getAddresses(){

    }
    protected function addAddress(){

    }

    protected function editAddress(){

    }
    protected function deleteAddress(){

    }
    protected function makeAddressDefault(){

    }
}
