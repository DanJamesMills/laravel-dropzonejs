<?php

namespace DanJamesMills\LaravelDropzone\Http\Requests\Api;

use InfyOm\Generator\Request\APIRequest;

class FileMoveAPIRequest extends APIRequest
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
            'file_folder_id' => 'required|exists:file_folders,id',
            'file_ids' => 'required|array',
            'file_ids.*' => 'required|exists:files,id'
        ];
    }
}
