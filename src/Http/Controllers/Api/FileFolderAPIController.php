<?php

namespace DanJamesMills\LaravelDropzone\Http\Controllers\Api;

// use App\Http\Requests\Api\v1\CreateCallAPIRequest;
// use App\Http\Requests\Api\v1\UpdateCallAPIRequest;
// use App\Models\Call;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class FileFolderAPIController
 * @package App\Http\Controllers\Api
 */

class FileFolderAPIController extends AppBaseController
{
    /**
     * Display a listing of the File Folders.
     * GET|HEAD /calls
     *
     * @param $object
     * @param $id
     * @return Response
     */
    public function index($object, $id)
    {
        $record = ('App\\Models\\'.ucfirst($object))::findOrFail($id);

        $fileFolders = $record->fileFolders()->get();

        return $this->sendResponse($fileFolders->toArray(), 'File folders retrieved successfully');
    }

    /**
     * Store a newly created Call in storage.
     * POST /calls
     *
     * @param CreateCallAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCallAPIRequest $request, $model, $id)
    {
        $record = ('App\\Models\\'.ucfirst($model))::findOrFail($id);

        $input = $request->all();

        /** @var Call $call */
        $call = Call::create($input);

        $record->calls()->save($call);

        return $this->sendResponse($call->load('user')->toArray(), 'Call saved successfully');
    }

    /**
     * Display the specified Call.
     * GET|HEAD /calls/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Call $call */
        $call = Call::find($id);

        if (empty($call)) {
            return $this->sendError('Call not found');
        }

        return $this->sendResponse($call->toArray(), 'Call retrieved successfully');
    }

    /**
     * Update the specified Call in storage.
     * PUT/PATCH /calls/{id}
     *
     * @param int $id
     * @param UpdateCallAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCallAPIRequest $request)
    {
        /** @var Call $call */
        $call = Call::find($id);

        if (empty($call)) {
            return $this->sendError('Call not found');
        }

        $call->fill($request->all());
        $call->save();

        return $this->sendResponse($call->toArray(), 'Call updated successfully');
    }

    /**
     * Remove the specified Call from storage.
     * DELETE /calls/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Call $call */
        $call = Call::find($id);

        if (empty($call)) {
            return $this->sendError('Call not found');
        }

        $call->delete();

        return $this->sendSuccess('Call deleted successfully');
    }
}
