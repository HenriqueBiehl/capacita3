<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'movie_poster' => 'file|mimes:jpeg,jpg,bmp,png|max:2048',
            'year' => 'required|integer|gt:0',
            'producer'=>'required|string|max:255',
            'run_time' => 'required|string|max:10',
        ];
    }
}
