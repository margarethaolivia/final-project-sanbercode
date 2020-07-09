<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Question extends Model
{
    protected $fillable = ['judul', 'isi', 'user_id', 'tags'];
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function answers()
    {
        return $this->hasMany('App\Answer', 'pertanyaan_id', 'id');
    }

    public function upvotes()
    {
        return $this->hasMany('App\Upvote', 'pertanyaan_id', 'id');
    }
    
    public function downvotes()
    {
        return $this->hasMany('App\Downvote', 'pertanyaan_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany('App\CommentQuestion', 'pertanyaan_id', 'id');
    }

    public function is_upvoted_by_auth_user()
    {
        $id = Auth::id();
        $upvoters = [];
        
        foreach ($this->upvotes as $upvote):
            array_push($upvoters, $upvote->user_id);
        endforeach;

        if(in_array($id, $upvoters)) {
            return true;
        } else {
            return false;
        }
    }

    public function is_downvoted_by_auth_user()
    {
        $id = Auth::id();
        $downvoters = [];
        
        foreach ($this->downvotes as $downvote):
            array_push($downvoters, $downvote->user_id);
        endforeach;

        if(in_array($id, $downvoters)) {
            return true;
        } else {
            return false;
        }
    }
}
