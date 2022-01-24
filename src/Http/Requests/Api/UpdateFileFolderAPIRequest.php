<?php

namespace DanJamesMills\LaravelDropzone\Http\Requests\Api;

use InfyOm\Generator\Request\APIRequest;

class UpdateFileFolderAPIRequest extends APIRequest
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
            'name' => 'required|max:100',
            'parent_file_folder_id' => 'nullable|exists:file_folders,id',
            'access_type' => 'nullable|in:1,2,3'
        ];
    }
}
