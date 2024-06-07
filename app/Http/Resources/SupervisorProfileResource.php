<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SupervisorProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return ["id"=>$this->id,
            "name_supervisor"=> $this->user->first_name . " " . $this->user->last_name,
            "email"=> $this->user->email ,
            "gender"=> $this->user->gender ,
            "mobile_phone"=> $this->user->mobile_phone ,
            "address"=> $this->user->address ,
            "nationality"=> $this->user->nationality ,
            "birth_date"=> $this->user->birth_date ,
            "role"=> $this->user->role->name,



        ];
    }
}
