<?php

namespace DanJamesMills\LaravelDropzone\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class CreateFileFolderApiRequest extends FormRequest
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
            'model' => 'required|string',
            'model_id' => 'required|numeric',
            'name' => 'required|max:50',
            'parent_file_folder_id' => 'nullable|exists:file_folders,id',
            'access_type' => 'required|in:1,2,3',
            'user_ids' => 'required_if:access_type,3',
            'user_ids.*' => 'nullable|exists:users,id',
        ];
    }
}
