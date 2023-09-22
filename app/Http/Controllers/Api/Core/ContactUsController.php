<?php

namespace App\Http\Controllers\Api\Core;

 use App\Http\Controllers\Controller;
 use App\Http\Requests\Api\Core\ContactRequest;
 use App\Models\ContactUs;
 use App\Support\Api\ApiResponse;


 class ContactUsController extends Controller
{
    use ApiResponse;
     public function __construct()
     {
         $this->middleware('localization');
     }
    public  function store(ContactRequest $request)
    {
        $this->body['contact'] = ContactUs::create($request->all());
        return self::apiResponse(200, t_('send your request successfully'), $this->body);

    }
}
