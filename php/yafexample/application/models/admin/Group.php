<?php

namespace Admin;

use Illuminate\Database\Eloquent\Model;

use \Admin\GroupModel as Group;


class GroupModel extends Model
{

    protected $table = \GameConst::TBL_AKUADMIN_GROUP;

    protected $dateFormat = 'U';

    protected $connection = \GameConst::DB_AKUADMIN;

    
    
    public function users()
    {
        return $this->belongsTo('\Admin\GroupModel', 'id');
    }


}