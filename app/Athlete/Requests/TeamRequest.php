<?php namespace Athlete\Requests;

use Laracasts\Validation\FormValidator;

class TeamRequest extends FormValidator
{

    protected $rules = [];

    public function rules($sportId, $teamId = null)
    {
        $this->rules = [
            'name' => "required|unique:teams,name,{$teamId},id,sport_id,{$sportId}"
        ];

        return $this;
    }
}
