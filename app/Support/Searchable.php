<?php

namespace App\Support;

use Illuminate\Support\Arr;

trait Searchable
{
	public function scopeSearch($query, $term)
	{
		if(empty($term)) return;
		
		$columns = $this->searchBy ?? 'name';
		$pattern = $this->getPattern($term);

		if(is_array($columns))
		{
			return $query->where(function($query) use ($pattern, $columns) {

				foreach ($columns as $column)
				{
					$query->orWhere($column, 'like', $pattern);
				}
			});
		}

		return $query->where($columns, 'like', $pattern);
	}

	protected function getPattern($term)
	{
		$searchMode = $this->searchMode ?? 'contains';

		if($searchMode == 'contains')
		{
			return '%'.static::escapeLikeQuery($term).'%';
		}
		elseif($searchMode == 'startWith')
		{
			return static::escapeLikeQuery($term).'%';
		}
		elseif($searchMode == 'full')
		{
			$term = static::escapeLikeQuery(' '.join(' ', Arr::where(explode(' ', $term), function($item) {
				return strlen($item) > 0;
			})).' ');

			return str_replace([' '], ['%'], $term);
		}
		elseif($searchMode == 'endWith')
		{
			return '%'.static::escapeLikeQuery($term);
		}
	}

	protected static function escapeLikeQuery($term)
	{
		return str_replace(['//', '%', '_'], ['////', '//%', '//_'], $term);
	}
}