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

    static function is_auth($user_id, $hash)
    {
        if( $curl = curl_init() ) {
            curl_setopt($curl, CURLOPT_URL, 'http://archicad-master.ru/engine/ajax/user_auth.php');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, "user_id=".$user_id."&hash=".$hash."&key=".getenv('AC_KEY'));
            $out = curl_exec($curl);
            if($out=="true") return true;
            curl_close($curl);
        }
        return false;

    }

    static function conver_date($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('ymd');
    }

    static function get_file(Files $file, $user_id)
    {
        $adate = self::conver_date($file->last);

        $name_file = $file->md5_name."_".$user_id."_".$adate.".xml";

        $nix_file = base_path().'/files/user_files/'.$name_file;

        $win_file = "Z:".str_replace("/", "\\", $nix_file);


        if(!is_file($nix_file)) {

            $orig_nix_file = base_path().'/files/xml/'.$file->md5_name.'.xml';

            $orig_win_file = "Z:".str_replace("/", "\\", $orig_nix_file);

            $comand = 'wine '.base_path().'/autocad/LP_XMLConverter.exe xml2libpart -l UTF8 "'.$orig_win_file.'" "'.$win_file.'"';

            exec($comand);

            if(!is_file($nix_file)) die("error create file");
        }

        return Response::download($nix_file, $name_file);
    }


}
