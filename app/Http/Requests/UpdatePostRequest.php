<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
            'title' => 'required|unique:posts,title,' . request()->route('post')->id,
            'body' => 'required',
            'time_to_read' => 'required',
            'image_source' => 'max:200',
            'published' => '',
            'category_id' => 'required',
            'image' => 'sometimes|file|image|max:5000',
        ];
    }
}
