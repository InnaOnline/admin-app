<?php

namespace App\Http\Requests\Department;

use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StoreDepartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     ** @param  \Illuminate\Http\Request
     * @return string[]
     */
    public function rules(StoreDepartmentRequest $request)
    {
        return [
            'name' => 'required|min:3|max:255',
            'started_at' => 'required|date_format:Y-m-d',
            'workers' => 'array'
        ];
    }
}
