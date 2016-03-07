<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectItemCategory extends Model
{
    //
    protected $table = 'proj_item_categories';

    public function scopejoinCategory($query)
    {
    	$cat = (new Category)->getTable();
    	return $query->leftJoin($cat, $cat.'.id', '=', $this->getTable() . '.category_id');
    }
}
