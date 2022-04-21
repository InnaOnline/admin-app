<?php

namespace App\Http\Requests\Department;

use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class UpdateDepartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function rules()
    {
        return [
            'id' => $department->id,
            'name' => $department->name,
            'started_at' => $department->started_at,
            'workers' => $department->workers,
        ];
    }
}
