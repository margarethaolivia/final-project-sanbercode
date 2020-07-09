<?php

namespace App;
use Auth;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    
    public function questions()
    {
        return $this->hasMany('App\Question');
    }

    public function answers()
    {
        return $this->hasMany('App\Answer');
    }

    public function profile()
    {
        return $this->belongsTo('App\Profile');
    }

    public function upvotes()
    {
        return $this->hasMany('App\Upvote');
    }

    public function reputasi($id)
    {
        $upvote = 0;
        $downvote = 0;
        $is_selected = 0;
        $upvoteAnswer = 0;
        $downvoteAnswer = 0;
        $questions = $this->questions->where('user_id', $id);
        $answers = $this->answers->where('user_id', $id);

        foreach($questions as $question) {
            $upvote += Upvote::where('pertanyaan_id', $question->id)->where('user_id', '!=', $question->user_id)->count();
            $downvote += Downvote::where('pertanyaan_id', $question->id)->count();
        }

        foreach($answers as $answer) {
            $upvoteAnswer += UpvoteAnswer::where('jawaban_id', $answer->id)->where('user_id', '!=', $answer->user_id)->count();
            $downvoteAnswer += DownvoteAnswer::where('jawaban_id', $answer->id)->count();

            if($answer->is_selected == 1) {
                $is_selected += 1;
            }
        }

        return ($is_selected*15 + $upvote*10 - $downvote + $upvoteAnswer*10 - $downvoteAnswer);
    }
}
