<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $array =  parent::toArray($request);
        $array['media_src'] = url('/') . '/uploads/medias/' . $this->attachment;
        $array['ext'] = pathinfo($this->attachment, PATHINFO_EXTENSION);
        $array['type'] = ext_type_image_or_other($array['ext']);
        $array['name'] = $this->name ? $this->name : 'No Name';
        return $array;
    }



}
