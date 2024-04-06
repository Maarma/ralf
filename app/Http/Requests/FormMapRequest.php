<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class FormMapRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()   
    {
        /** 
         * By default it returns false, change it to 
         * something like this if u are checking authentication
         */
        return Auth::check(); // <-------

        /** 
         * You could also use something more granular, like
         * a policy rule or an admin validation like this:
         * return auth()->user()->isAdmin();
         * 
         * Or just return true if you handle the authorisation
         * anywhere else:
         * return true;
         */ 
    }

    public function rules(): array
    {
        // your validations...
        return [
            //
        ];
    }

}