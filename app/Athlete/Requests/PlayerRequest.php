<?php namespace Athlete\Requests;

use Laracasts\Validation\FormValidator;

class PlayerRequest extends FormValidator
{

    protected $rules = [
        'first_name' => 'required',
        'last_name' => 'required',
        'image' => 'required|mimes:jpeg,bmp,png',
        'mime' => 'required_with:image|in:image/jpeg,image/png,image/bmp',
        'image_type' => 'required_with:image|in:uploaded,default',
        'born_on' => 'required|sometimes',
        'height_unit' => 'required|sometimes|in:in,cm',
        'height_value' => 'required_with:height_unit',
        'weight_unit' => 'required|sometimes|in:kg,lbs',
        'weight_value' => 'required_with:weight_unit'
    ];

    public function updateRules()
    {
        $this->rules = [
            'first_name' => 'required|sometimes',
            'last_name' => 'required|sometimes',
            'image' => 'required|sometimes|mimes:jpeg,bmp,png',
            'mime' => 'required_with:image|in:image/jpeg,image/png,image/bmp',
            'image_type' => 'required_with:image|in:uploaded,default',
            'born_on' => 'required|sometimes',
            'height_unit' => 'required|sometimes|in:in,cm',
            'height_value' => 'required_with:height_unit',
            'weight_unit' => 'required|sometimes|in:kg,lbs',
            'weight_value' => 'required_with:weight_unit',
            'note' => 'required|sometimes'
        ];

        return $this;
    }
}
