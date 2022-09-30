<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostBookRequest extends FormRequest
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
        // @TODO implement
        return [
            'isbn' => 'required|digits:13|unique:App\Book,isbn',
            'title' => 'required|string',
            'description' => 'required|string',
            'authors' => 'required|integer',
            'published_year' => 'required|digits_between:1900,2020'
        ];
    }
}