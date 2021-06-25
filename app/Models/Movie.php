<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'pubDate', 'movieImage', 'status'
    ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function slots()
  {
        return $this->belongsToMany('App\Models\Slot', 'movie_slots', 'movie_id', 'slot_id');
  }
}