<?php

namespace App\Http\Controllers;

use App\Exceptions\RequestException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function validateRequestParameters(array $request, array $rules, array $messages = [])
    {
        $validator = Validator::make($request, $rules, $messages);

        if ($validator->fails()) {
            throw new RequestException($validator->errors()->getMessages());
        }
    }
}
