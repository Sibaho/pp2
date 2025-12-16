<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Aset extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function monitorings()
    {
        return $this->hasMany(Monitoring::class, 'aset_id');
    }
}
