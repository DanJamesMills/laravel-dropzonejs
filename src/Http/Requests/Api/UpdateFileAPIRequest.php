<?php

namespace DanJamesMills\LaravelDropzone\Http\Requests\Api;

use InfyOm\Generator\Request\APIRequest;

class UpdateFileAPIRequest extends APIRequest
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
            'original_filename' => 'required|max:100',
        ];
    }
}
