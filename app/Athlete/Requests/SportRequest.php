<?php namespace Athlete\Requests;

use Laracasts\Validation\FormValidator;

class SportRequest extends FormValidator
{

    protected $rules = [];

    public function rules($userId)
    {
        $this->rules = [
            'name' => "required|unique:sports,name,null,id,user_id,{$userId}",
            'image' => 'required|sometimes|mimes:jpeg,bmp,png',
            'mime' => 'required_with:image|in:image/jpeg,image/png,image/bmp',
            'image_type' => 'required_with:image|in:uploaded,default'
        ];

        return $this;
    }

    public function updateRules($userId, $sportId)
    {
        $this->rules = [
            'name' => "required|unique:sports,name,{$sportId},id,user_id,{$userId}",
            'image' => 'required|sometimes|mimes:jpeg,bmp,png',
            'mime' => 'required_with:image|in:image/jpeg,image/png,image/bmp',
            'image_type' => 'required_with:image|in:uploaded,default'
        ];

        return $this;
    }
}
