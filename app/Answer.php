<?php

namespace App;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['isi', 'pertanyaan_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function question()
    {
        return $this->belongsTo('App\Question', 'pertanyaan_id');
    }

    public function upvotes()
    {
        return $this->hasMany('App\UpvoteAnswer', 'jawaban_id', 'id');
    }
    
    public function downvotes()
    {
        return $this->hasMany('App\DownvoteAnswer', 'jawaban_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany('App\CommentAnswer', 'jawaban_id', 'id');
    }

    public function is_selected_by_user_question()
    {
        if($this->is_selected == 1) {
            return true;
        } else {
            return false;
        }
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
