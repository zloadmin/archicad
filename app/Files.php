<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    protected $table = 'files';

    protected $fillable = ['name', 'md5_name', 'original_name', 'type', 'last_date', 'reload'];
}
