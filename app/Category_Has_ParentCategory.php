<?php

namespace MetodikaTI;

use Illuminate\Database\Eloquent\Model;

class Category_Has_ParentCategory extends Model
{
    protected $table = 'category_has_parentcategory';

    protected $fillable = ['parent_category_id', 'category_id', 'created_at', 'updated_at'];

}
