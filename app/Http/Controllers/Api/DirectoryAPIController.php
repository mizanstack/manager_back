<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateDirectoryAPIRequest;
use App\Http\Requests\API\UpdateDirectoryAPIRequest;
use App\Models\Directory;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class DirectoryController
 * @package App\Http\Controllers\API
 */

class DirectoryAPIController extends AppBaseController
{

    

    /**
     * Display a listing of the Directory.
     * GET|HEAD /directories
     *
     * @param Request $request
     * @return Response
     */
    public function get_directories(Request $request)
    {
        $query = Directory::query();

        if ($request->get('parent_id')) {
            $query->where('parent_id', $request->get('parent_id'));
        } else {
            $query->where('parent_id', null);
        }
        

        $directories = $query->get();

        return $this->sendResponse($directories->toArray(), 'Directories retrieved successfully');
    }


    /**
     * Display a listing of the Directory.
     * GET|HEAD /directories
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = Directory::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $directories = $query->get();

        return $this->sendResponse($directories->toArray(), 'Directories retrieved successfully');
    }

    /**
     * Store a newly created Directory in storage.
     * POST /directories
     *
     * @param CreateDirectoryAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateDirectoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var Directory $directory */
        $directory = Directory::create($input);

        return $this->sendResponse($directory->toArray(), 'Directory saved successfully');
    }

    /**
     * Display the specified Directory.
     * GET|HEAD /directories/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Directory $directory */
        $directory = Directory::find($id);

        if (empty($directory)) {
            return $this->sendError('Directory not found');
        }

        return $this->sendResponse($directory->toArray(), 'Directory retrieved successfully');
    }

    /**
     * Update the specified Directory in storage.
     * PUT/PATCH /directories/{id}
     *
     * @param int $id
     * @param UpdateDirectoryAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDirectoryAPIRequest $request)
    {
        /** @var Directory $directory */
        $directory = Directory::find($id);

        if (empty($directory)) {
            return $this->sendError('Directory not found');
        }

        $directory->fill($request->all());
        $directory->save();

        return $this->sendResponse($directory->toArray(), 'Directory updated successfully');
    }

    /**
     * Remove the specified Directory from storage.
     * DELETE /directories/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Directory $directory */
        $directory = Directory::find($id);

        if (empty($directory)) {
            return $this->sendError('Directory not found');
        }

        $directory->delete();

        return $this->sendSuccess('Directory deleted successfully');
    }
}
