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
     * Display a search of the Directory.
     * GET|HEAD /search directories and files
     *
     * @param Request $request
     * @return Response
     */


    public function get_search_data(Request $request)
    {

        $query = Directory::query();

        if ($request->get('parent_id')) {
            $query->where('parent_id', $request->get('parent_id'));
        } else {
            $query->where('parent_id', null);
        }

        $query->where('name', 'like', '%'.request('search').'%');
        $query->orderBy('id', request('sort'));

        $directories = $query->paginate(15);

        return DirectoryResource::collection($directories);
    }



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

        $query->orderBy('id', request('sort'));

        $directories = $query->paginate(50);

        return DirectoryResource::collection($directories);

        // return $this->sendResponse($directories->toArray(), 'Directories retrieved successfully');
    }


    /**
     * Copy Directory.
     * GET/directories
     *
     * @param Request $request
     * @return Response
     */

    public function copy_folder($id, $paste_id=null){
        DB::beginTransaction();
        try {
            $copy_directory = Directory::find($id)->toArray();

            $paste_directory = new Directory;

            if($copy_directory['parent_id'] == $paste_id){
                // current directory
                $copy_directory['name'] = $copy_directory['name'] . ' Copy';
            }

            $copy_directory['parent_id'] = $paste_id ? $paste_id : null;
            $created = $paste_directory->create($copy_directory);

            \App\Models\Directory::childrenCopy($id, $created->id);
            \App\Models\Media::childrenCopy($id, $created->id);
            DB::commit();
            return $this->sendResponse([], 'Copy Folder Successfully');

        } catch (\Throwable $e) {
            DB::rollback();
            return $this->sendError($e->getMessage());
        }
        
    }


    /**
     * Cut Directory.
     * GET/directories
     *
     * @param Request $request
     * @return Response
     */

    public function cut_folder($id, $paste_id=null){
        DB::beginTransaction();
        try {
            $cut_directory = Directory::find($id);
            $cut_directory->parent_id = $paste_id;
            $cut_directory->save();
            DB::commit();
            return $this->sendResponse([], 'Folder Moved Successfully');

        } catch (\Throwable $e) {
            DB::rollback();
            return $this->sendError($e->getMessage());
        }
        
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
        $directories = \App\Models\Directory::where('parent_id', $id);
        $directories = $directories->orderBy('id', request('sort'));
        $directories = $directories->get();

        $medias = \App\Models\Media::where('directory_id', $id)->orderBy('id', request('sort'))->get();
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
        DB::beginTransaction();
        try {
            $input = $request->all();
            $directory = new Directory;
            $directory->parent_id = $request->parentId;
            $directory->name = $request->name;
            $directory->slug = \Illuminate\Support\Str::slug($request->name);
            $directory->save();
            DB::commit();

            return $this->sendResponse($directory->toArray(), 'Directory saved successfully');

        } catch (\Throwable $e) {
            DB::rollback();
            return $this->sendError($e->getMessage());
        }

        

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

        DB::beginTransaction();
        try {
            $input = $request->all();
            $directory = Directory::find($id);

            if($directory){
                $directory->name = $request->name;
                $directory->slug = \Illuminate\Support\Str::slug($request->name);
                $directory->save();
            }
            DB::commit();
            return $this->sendResponse($directory->toArray(), 'Directory saved successfully'); 

        } catch (\Throwable $e) {
            DB::rollback();
            return $this->sendError($e->getMessage());
        }
        
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
            \App\Models\Directory::childrenDelete($directory->id);
            \App\Models\Media::childrenDelete($directory->id);

            $directory->delete();

            DB::commit();
            return $this->sendSuccess('Directory deleted successfully');


        } catch (\Throwable $e) {
            DB::rollback();
            return $this->sendError($e->getMessage());
        }


        
    }
}
