<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateMediaAPIRequest;
use App\Http\Requests\API\UpdateMediaAPIRequest;
use App\Models\Media;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class MediaController
 * @package App\Http\Controllers\API
 */

class MediaAPIController extends AppBaseController
{
    /**
     * Display a listing of the Media.
     * GET|HEAD /media
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = Media::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $media = $query->get();

        return $this->sendResponse($media->toArray(), 'Media retrieved successfully');
    }

    /**
     * Store a newly created Media in storage.
     * POST /media
     *
     * @param CreateMediaAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateMediaAPIRequest $request)
    {
        $input = $request->all();

        /** @var Media $media */
        $media = Media::create($input);

        return $this->sendResponse($media->toArray(), 'Media saved successfully');
    }

    /**
     * Display the specified Media.
     * GET|HEAD /media/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Media $media */
        $media = Media::find($id);

        if (empty($media)) {
            return $this->sendError('Media not found');
        }

        return $this->sendResponse($media->toArray(), 'Media retrieved successfully');
    }

    /**
     * Update the specified Media in storage.
     * PUT/PATCH /media/{id}
     *
     * @param int $id
     * @param UpdateMediaAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMediaAPIRequest $request)
    {
        /** @var Media $media */
        $media = Media::find($id);

        if (empty($media)) {
            return $this->sendError('Media not found');
        }

        $media->fill($request->all());
        $media->save();

        return $this->sendResponse($media->toArray(), 'Media updated successfully');
    }

    /**
     * Remove the specified Media from storage.
     * DELETE /media/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Media $media */
        $media = Media::find($id);

        if (empty($media)) {
            return $this->sendError('Media not found');
        }

        $media->delete();

        return $this->sendSuccess('Media deleted successfully');
    }
}
