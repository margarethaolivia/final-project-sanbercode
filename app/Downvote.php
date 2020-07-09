<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Downvote extends Model
{
    protected $fillable = ['user_id', 'pertanyaan_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function question()
    {
        return $this->belongsTo('App\Question');
    }
}
