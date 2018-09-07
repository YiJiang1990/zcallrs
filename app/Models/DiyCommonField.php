<?php

namespace App\Models;

use App\Models\DIY\ValueEditor;
use App\Models\DIY\ValueFile;
use App\Models\DIY\ValueImage;
use App\Models\DIY\ValueInput;
use App\Models\DIY\ValueOption;
use App\Models\DIY\ValueTime;
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
        'name', 'title', 'from', 'parent_type', 'children_type', 'style_type','parent_uid','selects_tab_id'
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
        return $this->where('parent_uid', Auth::user()->parent_uid)
            ->where('from', 'setting')
            ->where('name',$name)
            ->with('optionsWith')
            ->get();
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
    public function selectsTabWith()
    {
        return $this->belongsTo(SelectTab::class,'selects_tab_id');
     }

}
