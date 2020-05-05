<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Games extends Model
{
  protected $table = "games";

  public function p1_name(){
    return $this->hasOne("App\Users", "id", "fkey_p1_id");
  }

  public function p2_name(){
    return $this->hasOne("App\Users", "id", "fkey_p2_id");
  }

  public function p3_name(){
    return $this->hasOne("App\Users", "id", "fkey_p3_id");
  }

  public function p4_name(){
    return $this->hasOne("App\Users", "id", "fkey_p4_id");
  }

}
