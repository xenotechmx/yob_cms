<?php

namespace MetodikaTI;

use Illuminate\Database\Eloquent\Model;

class ParentCategory extends Model
{
    protected $table = 'parent_categories';

    protected $primaryKey = 'id';

    protected $fillable = ['category', 'created_at', 'updated_at'];

    public function categories(){
        return $this->belongsToMany('\MetodikaTI\Category','category_has_parentcategory')
            ->withPivot('category_id','parent_category_id'); 
    }
}
