<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Files extends Model
{
    protected $table = 'files';

    protected $fillable = ['name', 'md5_name', 'original_name', 'type', 'last_date', 'reload'];

    protected $appends = ['last'];


    public function getLastAttribute()
    {
        if($this->attributes['type']==1) {
            return $this->attributes['last_date'];
        }
        if($this->attributes['type']==2) {

            $now_time = Carbon::now()->timestamp;
            $created_time = Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at'])->timestamp;
            $period_time = $this->attributes['reload'];

            $proshlo = $now_time - $created_time;

            $periods = intval($proshlo / $period_time + 1);

            $add_time = $period_time * $periods;

            $last_time = $created_time + $add_time;

            $last_time_str = date('Y-m-d H:i:s', $last_time);

            return $last_time_str;
        }
    }


}
