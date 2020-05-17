<?php

namespace MetodikaTI;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $primaryKey = 'id';

    protected $fillable = ['category', 'created_at', 'updated_at'];

    public function parent_categories(){
        return $this->belongsToMany('\MetodikaTI\ParentCategory','category_has_parentcategory')
            ->withPivot('parent_category_id','category_id'); 
    }
}
