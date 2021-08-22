<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateMediaAPIRequest;
use App\Http\Requests\API\UpdateMediaAPIRequest;
use App\Models\Media;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use DB;

/**
 * Class MediaController
 * @package App\Http\Controllers\API
 */

class MediaAPIController extends AppBaseController
{
    

    public function upload_files(Request $request){


        $request->validate([

           
            // 'name' => 'required',
            'attachment'  => 'required|mimes:'.env('FILE_UPLOAD_SUPPORT_TYPE').'|max:'.env('FILE_UPLOAD_MAX_SIZE').'',
       ],
       [
       ]);



       try {
            DB::beginTransaction();

            $media = new media;
            $media->name  =  request('attachment')->getClientOriginalName();

            $media->directory_id  =  $request->directory_id ? $request->directory_id : null;
            $media->attachment  =  $media->uploadFileVue('attachment', 'media_', 'uploads/medias/');
            $media->save();

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Upload successfully']);
       }
       catch( \Execption $e ) {
            DB::rollBack();

            return response()->json(['status' => 'error', 'message' => 'Something wrong']);
       }
    }


    /**
     * Copy Media.
     * GET/Media
     *
     * @param Request $request
     * @return Response
     */

    public function copy_media($id, $paste_id=null){

        if($paste_id == null){
            return $this->sendError('You can not paste media on root directory');
        }

        DB::beginTransaction();

        try {
            $copy_media = Media::find($id);

            $media = new Media;

            if($copy_media->directory_id == $paste_id){
                // same directory
                $media->name = add_text_before_ext($text='_copy', $copy_media->name);
            } else {
                // another directory
                $media->name = $copy_media->name;
            }

            $media->attachment = add_text_before_ext($text='_copy', $copy_media->attachment);

            $file = public_path("/uploads/medias/" . $copy_media->attachment);
            $destination = public_path("/uploads/medias/". $media->attachment);

            if(\File::exists($file)){
                \File::copy($file,$destination);
            }


            $media->directory_id  =  $paste_id ? $paste_id : null;
            $media->save();

            DB::commit();
            return $this->sendResponse([], 'Copy Media Successfully');

        } catch (\Throwable $e) {
            DB::rollback();
            return $this->sendError($e->getMessage());
        }
        
    }


    /**
     * Cut Media.
     * GET/Media
     *
     * @param Request $request
     * @return Response
     */

    public function cut_media($id, $paste_id=null){

        if($paste_id == null){
            return $this->sendError('You can not paste media on root directory');
        }

        DB::beginTransaction();
        try {
            $cut_media = Media::find($id);
            $cut_media->directory_id = $paste_id;
            $cut_media->save();
            DB::commit();
            return $this->sendResponse([], 'Media Moved Successfully');

        } catch (\Throwable $e) {
            DB::rollback();
            return $this->sendError($e->getMessage());
        }
        
    }




    public function destroy($id)
    {
        /** @var Media $media */
        $media = Media::find($id);

        if (empty($media)) {
            return $this->sendError('Media not found');
        }

        $file = public_path("/uploads/medias/" . $media->attachment);
        if (\File::exists($file)) { // unlink or remove previous image from folder
            unlink($file);
        }

        $media->delete();

        return $this->sendSuccess('Media deleted successfully');
    }
}
