<?php

namespace App\Modules\Alumno\Requests;

use App\Models\Alumno;
use Illuminate\Foundation\Http\FormRequest;

class AlumnoRequest extends FormRequest
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
     *
     * @return array
     */
    public function rules()
    {
        return [
            Alumno::COLUMN_NAME => 'required|string',
        ];
    }
}
