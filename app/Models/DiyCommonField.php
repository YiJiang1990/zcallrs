<?php

namespace App\Models;

use App\Models\DIY\ValueEditor;
use App\Models\DIY\ValueFile;
use App\Models\DIY\ValueImage;
use App\Models\DIY\ValueInput;
use App\Models\DIY\ValueOption;
use App\Models\DIY\ValueOptionTree;
use App\Models\DIY\ValueTime;
use App\Models\Tree\Option;
use Auth;

/**
 * Class DiyCommonField
 * @package App\Models
 */
class DiyCommonField extends Model
{
    /**
     * @var string
     */
    protected $table = 'diy_common_field';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'title', 'from', 'parent_type', 'children_type', 'style_type','parent_uid','selects_tab_id', 'tree_select_tab_id'
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];


    /**
     * @return mixed
     */
    public function getCorporateDiyCommonFieldWith($name)
    {
        $data =  $this->where('parent_uid', Auth::user()->parent_uid)
            ->where('from', 'setting')
            ->where('name',$name)
            ->with('optionsWith')
            ->get();
         $data->map(function ($item, $key )use ($data){
            if ($item->tree_select_tab_id) {
                $allCategories = Option::where('tree_select_tab_id',$item->tree_select_tab_id)->get();
                $item->option_tree = $this->getCategoryTree(null, $allCategories);
            }
        });
        return $data;
     }

    public function getCorporateDiyCommonFieldByInput($type)
    {
        return $this->where('parent_uid', Auth::user()->parent_uid)
            ->where('from', 'setting')
            ->where('parent_type','input')
            ->where('status',1)
            ->where('name',$type)
            ->select(['id','title'])
            ->get();
     }
     
    /**
     * @return mixed
     */
    public function getCorporateDiyCommonFieldWithBy($ids)
    {
        return $this->where('parent_uid', Auth::user()->parent_uid)
            ->where('from', 'setting')
            ->whereIn('id',$ids)
            //->with('optionsWith')
            ->get();
    }
    public function inputWith()
    {
       return $this->hasMany(ValueInput::class,'diy_common_filed_id','id');
    }

    public function optionWith()
    {
       return $this->hasMany(ValueOption::class,'diy_common_filed_id','id');
    }

    public function timeWith()
    {
       return $this->hasMany(ValueTime::class,'diy_common_filed_id','id');
    }

    public function imageWith()
    {
        return $this->hasMany(ValueImage::class,'diy_common_filed_id','id');
    }

    public function fileWith()
    {
        return $this->hasMany(ValueFile::class,'diy_common_filed_id','id');
    }

    public function editorWith()
    {
        return $this->hasMany(ValueEditor::class,'diy_common_filed_id','id');
    }

    public function optionsWith()
    {
        return $this->hasMany(Options::class,'selects_tab_id','selects_tab_id')->select(['id','name','selects_tab_id']);
    }

    public function optionsTreeWith(){
        return $this->hasMany(ValueOptionTree::class, 'diy_common_filed_id','id');
    }

    public function getCategoryTree($parentId = null, $allCategories = null) {


        return $allCategories
            // 从所有类目中挑选出父类目 ID 为 $parentId 的类目
            ->where('pid', $parentId)
            // 遍历这些类目，并用返回值构建一个新的集合
            ->map(function (Option $category) use ($allCategories) {

                $data = ['value' => $category->id, 'label' => $category->name];

                // 如果当前类目不是父类目，则直接返回
                if (!$category->is_directory) {
                    return $data;
                }
                // 否则递归调用本方法，将返回值放入 children 字段中
                $data['children'] = $this->getCategoryTree($category->id, $allCategories);
                return $data;
            });
    }

    public function selectsTabWith()
    {
        return $this->belongsTo(SelectTab::class,'selects_tab_id');
     }

}
