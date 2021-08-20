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
            'attachment'  => 'required|mimes:jpeg,png,pdf|max:2000048',
            // 'name.*.files'    => 'required|mimes:jpeg,png,pdf|max:2048',
       ],
       [
       ]);



       try {
            DB::beginTransaction();

            $media = new media;
            $media->name  =  request('attachment')->getClientOriginalName();
            $media->directory_id  =  $request->directory_id;
            $media->attachment  =  $media->uploadFileVue('attachment', 'media_', 'uploads/medias/');
            $media->save();


            // if($request->award_status){
            //     foreach ($request->award_list as $index => $award) {
            //         \App\Models\mediaAward::create([
            //             'media_id' => $media->id,
            //             'awcertificate' => $media->uploadFileVue(request('award_list')[$index]['awcertificate'], $media->name . '_awcertificate', 'uploads/awcertificate/', true),
            //             'status' => 1,
            //         ]);
            //     }
            // }

            DB::commit();
            // DB::rollBack();

            return response()->json(['status' => 'success', 'message' => 'Upload successfully']);
       }
       catch( \Execption $e ) {
            DB::rollBack();

            return response()->json(['status' => 'error', 'message' => 'Something wrong']);
       }



    }

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
