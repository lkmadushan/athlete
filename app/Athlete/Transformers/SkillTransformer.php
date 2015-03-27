<?php namespace Athlete\Transformers;

use Skill;
use League\Fractal\TransformerAbstract;

class SkillTransformer extends  TransformerAbstract {

	/**
	 * Transform skill
	 *
	 * @param \Skill $skill
	 * @return array
	 */
	public function transform(Skill $skill)
	{
		return [
			'skill_id' => $skill->id,
			'name' => $skill->name,
			'notes' => $skill->notes,
			'level' => $skill->level,
		];
	}
}