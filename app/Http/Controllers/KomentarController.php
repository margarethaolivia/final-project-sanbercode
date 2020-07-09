<?php

namespace App\Http\Controllers;

use App\CommentQuestion;
use App\CommentAnswer;
use Auth;

use Illuminate\Http\Request;

class KomentarController extends Controller
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
    public function storeQuestion(Request $request, $id)
    {
        CommentQuestion::create([
            'isi' => request('isi'),
            'pertanyaan_id' => request('pertanyaan_id'),
            'user_id' => Auth::id()
        ]);
        
        return redirect("/pertanyaan/$id");
    }

    public function storeAnswer(Request $request, $id, $question_id)
    {
        CommentAnswer::create([
            'isi' => request('isi'),
            'jawaban_id' => request('jawaban_id'),
            'user_id' => Auth::id()
        ]);
        
        return redirect("/pertanyaan/$question_id");
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
}
