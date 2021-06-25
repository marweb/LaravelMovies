<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    use HasFactory;

    protected $fillable = [
        'time', 'status'
    ];

 /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function movies()
  {
        return $this->belongsToMany('App\Models\Movie', 'movie_slots', 'slot_id', 'movie_id');

  }
}