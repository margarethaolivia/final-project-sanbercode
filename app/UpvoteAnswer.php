<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UpvoteAnswer extends Model
{
    protected $table = 'upvotes_answers';
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
