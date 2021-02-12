<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    protected $table = 'bitacoras';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'accion'];
    protected $timestamp = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
