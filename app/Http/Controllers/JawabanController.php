<?php

namespace App\Http\Controllers;
use App\Answer;
use App\UpvoteAnswer;
use App\DownvoteAnswer;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JawabanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        Answer::create([
            'isi' => request('isi'),
            'pertanyaan_id' => request('pertanyaan_id'),
            'user_id' => Auth::id()
        ]);
        
        return redirect("/pertanyaan/$id");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function selected($answer_id, $user_question, $user_answer)
    {
        if(Auth::id() == $user_question && Auth::id() != $user_answer) {

            Answer::where('id', $answer_id)
                    ->update([
                        'is_selected'=> 1
                    ]);
        }

        return redirect()->back();
    }

    public function unselected($answer_id, $user_question, $user_answer)
    {
        if(Auth::id() == $user_question) {
            Answer::where('id', $answer_id)
                    ->update([
                        'is_selected'=> 0
                    ]);
        }
                
        return redirect()->back();
    }

    public function upvote($id)
    {
        $downvote = DownvoteAnswer::where('jawaban_id', $id)->where('user_id', Auth::id())->first();

        if($downvote != null) {
            DownvoteAnswer::where('jawaban_id', $id)->where('user_id', Auth::id())->first()->delete();
        }

        UpvoteAnswer::create([
            'jawaban_id' => $id,
            'user_id' => Auth::id()
        ]);

        return redirect()->back();
    }
    
    public function unupvote($id)
    {
        UpvoteAnswer::where('jawaban_id', $id)->where('user_id', Auth::id())->first()->delete();
        return redirect()->back();
    }
    
    public function downvote($id)
    {
        if(User::where('id', Auth::id())->first()->reputasi(Auth::id()) >= 15) {
            
            DownvoteAnswer::create([
                'jawaban_id' => $id,
                'user_id' => Auth::id()
            ]);

            $upvote = UpvoteAnswer::where('jawaban_id', $id)->where('user_id', Auth::id())->first();
            
            if($upvote != null) {
                UpvoteAnswer::where('jawaban_id', $id)->where('user_id', Auth::id())->first()->delete();
            }
        }

        return redirect()->back();
    }
    
    public function undownvote($id)
    {
        DownvoteAnswer::where('jawaban_id', $id)->where('user_id', Auth::id())->first()->delete();
        return redirect()->back();
    }
}
