<?php namespace Athlete\Transformers;

use League\Fractal\TransformerAbstract;
use Skill;

class SkillTransformer extends TransformerAbstract
{

    /**
     * Transform skill
     *
     * @param \Skill $skill
     * @return array
     */
    public function transform(Skill $skill)
    {
        return [
            'skill_id' => (int)$skill->id,
            'name' => $skill->name,
            'notes' => $skill->notes,
            'level' => $skill->level,
        ];
    }
}
