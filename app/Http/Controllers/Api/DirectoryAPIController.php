<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateDirectoryAPIRequest;
use App\Http\Requests\API\UpdateDirectoryAPIRequest;
use App\Models\Directory;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Http\Resources\DirectoryResource;
use App\Http\Resources\MediaResource;
use DB;

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
     * Copy Directory.
     * GET/directories
     *
     * @param Request $request
     * @return Response
     */

    public function copy_folder($id, $paste_id=null){
        $copy_directory = Directory::find($id)->toArray();

        $paste_directory = new Directory;
        $copy_directory['name'] = $copy_directory['name'] . ' Copy';
        $copy_directory['parent_id'] = $paste_id ? $paste_id : null;
        $paste_directory->create($copy_directory);
        return $paste_directory;
    }


    /**
     * open a listing of the Directory.
     * GET|HEAD /directories
     *
     * @param Request $request
     * @return Response
     */
    public function open_directory($id, Request $request)
    {
        $current_directory = \App\Models\Directory::find($id);
        $directories = \App\Models\Directory::where('parent_id', $id)->get();

        $medias = \App\Models\Media::where('directory_id', $id)->latest()->get();
        $directory_medias = MediaResource::collection($medias);

        return DirectoryResource::collection($directories)->additional([
            'current_directory' => $current_directory,
            'medias' => $directory_medias
        ]);
    }

    /**
     * Store a newly created Directory in storage.
     * POST /directories
     *
     * @param CreateSaveFolderAPIRequest $request
     *
     * @return Response
     */


    public function save_folder(CreateDirectoryAPIRequest $request)
    {
        $input = $request->all();
        $directory = new Directory;
        $directory->parent_id = $request->parentId;
        $directory->name = $request->name;
        $directory->slug = \Illuminate\Support\Str::slug($request->name);
        $directory->save();

        return $this->sendResponse($directory->toArray(), 'Directory saved successfully');
    }


    /**
     * update a created Directory in storage.
     * POST /directories
     *
     * @param UpdateFolderAPIRequest $request
     *
     * @return Response
     */


    public function update_folder($id, CreateDirectoryAPIRequest $request)
    {
        $input = $request->all();
        $directory = Directory::find($id);

        if($directory){
            $directory->name = $request->name;
            $directory->slug = \Illuminate\Support\Str::slug($request->name);
            $directory->save();

            return $this->sendResponse($directory->toArray(), 'Directory saved successfully'); 
        }


         return $this->sendError('Directory not found');
        
    }

    /**
     * get Nested Directories for tree view
     * Get /nested_directories
     *
     * @param UpdateFolderAPIRequest $request
     *
     * @return Response
     */

    public function nested_directories(){
        $nested_array =  \App\Models\Directory::getNestedCategories();
        return $this->sendResponse($nested_array, 'Tree folder retrieved successfully'); 
    }


    public function destroy($id)
    {
        
        DB::beginTransaction();

        try {

            $directory = Directory::find($id);

            if (empty($directory)) {
                return $this->sendError('Directory not found');
            }
            // all sub folder delete need to update
            // $directory_medias = \App\Model\Media::where('directory_id', $id)->delete();
            $directory->delete();
            DB::commit();
            return $this->sendSuccess('Directory deleted successfully');


        } catch (\Throwable $e) {
            DB::rollback();
        }


        
    }
}
