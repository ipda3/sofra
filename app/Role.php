<?php
namespace App;

use Zizaco\Entrust\EntrustRole;


class Role extends EntrustRole

{
    protected $table = 'roles';
    public $timestamps = true;
    protected $fillable = array('name','display_name','description');

    public function permissions()
    {
        return $this->belongsToMany('App\Permission');
    }
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
    public function getPermissionsListAttribute($value)
    {
        return $this->permissions()->pluck('id')->toArray();
    }

}