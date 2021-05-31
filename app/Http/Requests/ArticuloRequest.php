<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticuloRequest extends FormRequest
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
            'descripcion'=>'required|min:4',
            'precio'=>'required',
            'stock'=>'required',
        ];
    }
    public function message()
    {       
        return [
            'descripcion.*'=>'Descripcion debe de tener minimo 4 caracteres',
            'precio.required'=>'La cantidad debe ser mayor a 0',
            'stock.required'=>'La cantidad debe ser mayor a 0',
        ];
    }
}
