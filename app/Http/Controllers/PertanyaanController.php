<?php

namespace App\Http\Controllers;
use App\Question;
use App\Answer;
use App\Upvote;
use App\Downvote;
use App\User;
use App\CommentAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PertanyaanController extends Controller
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
        $questions = Question::all();
        return view('pertanyaan_index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pertanyaan_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Question::create([
            'judul' => request('judul'),
            'isi' => request('isi'),
            'tags' => request('tags'),
            'user_id' => Auth::id()
        ]);
        return redirect('pertanyaan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::find($id);
        $answers = Question::find($id)->answers;

        $commentsQuestion = Question::find($id)->comments;
        $commentsAnswer = CommentAnswer::all();

        return view('pertanyaan_show', compact('question'), compact('answers'))
            ->with('commentsQuestion', $commentsQuestion)
            ->with('commentsAnswer', $commentsAnswer)
        ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::find($id);
        return view('pertanyaan_edit', compact('question'));
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
        Question::where('id', $id)
                ->update([
                    'judul'=> $request->judul,
                    'isi' => $request->isi,
                    'tags' => $request->tags
                ]);
        return redirect("/pertanyaan/$id");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Question::destroy($id);
        return redirect('pertanyaan');
    }

    public function upvote($id)
    {
        $downvote = Downvote::where('pertanyaan_id', $id)->where('user_id', Auth::id())->first();

        if($downvote != null) {
            Downvote::where('pertanyaan_id', $id)->where('user_id', Auth::id())->first()->delete();
        }

        Upvote::create([
            'pertanyaan_id' => $id,
            'user_id' => Auth::id()
        ]);

        return redirect()->back();
    }
    
    public function unupvote($id)
    {
        Upvote::where('pertanyaan_id', $id)->where('user_id', Auth::id())->first()->delete();
        return redirect()->back();
    }
    
    public function downvote($id)
    {
        if(User::where('id', Auth::id())->first()->reputasi(Auth::id()) >= 15) {
            
            Downvote::create([
                'pertanyaan_id' => $id,
                'user_id' => Auth::id()
            ]);

            $upvote = upvote::where('pertanyaan_id', $id)->where('user_id', Auth::id())->first();
            
            if($upvote != null) {
                upvote::where('pertanyaan_id', $id)->where('user_id', Auth::id())->first()->delete();
            }
        }

        return redirect()->back();
    }
    
    public function undownvote($id)
    {
        Downvote::where('pertanyaan_id', $id)->where('user_id', Auth::id())->first()->delete();
        return redirect()->back();
    }
}
