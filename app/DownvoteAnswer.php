<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DownvoteAnswer extends Model
{
    protected $table = 'downvotes_answers';
    protected $fillable = ['user_id', 'jawaban_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function answer()
    {
        return $this->belongsTo('App\Answer');
    }
}
