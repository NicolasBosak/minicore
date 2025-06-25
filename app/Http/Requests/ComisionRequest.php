<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComisionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'fecha_inicio' => 'required|date|before_or_equal:today',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio|before_or_equal:today'
        ];
    }

    public function messages()
    {
        return [
            'fecha_inicio.required' => 'La fecha de inicio es obligatoria',
            'fecha_inicio.date' => 'La fecha de inicio debe ser una fecha válida',
            'fecha_fin.required' => 'La fecha de fin es obligatoria',
            'fecha_fin.date' => 'La fecha de fin debe ser una fecha válida',
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio'
        ];
    }
}
