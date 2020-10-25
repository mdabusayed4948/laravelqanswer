<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Notifications\NewAnswerSubmitted;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'ans' => "required|min:15",
            'question_id' => 'required|integer'
        ]);

        $answer = new Answer();
        $answer->ans = $request->ans;
        $answer->user()->associate(Auth::id());

        $question = Question::findOrFail($request->question_id);
        $question->answers()->save($answer);
        $question->user->notify(new NewAnswerSubmitted($answer, $question, Auth::user()->name));

        return redirect()->route('questions.show', $question->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $style= 'display:none';
        $answer = Answer::findOrFail($id);

        $question = Question::findOrFail($answer->question_id);

        if ($answer->user->id != Auth::id()) {
            return abort(403);
        }
        return view('answer.edit', compact('answer','question','style'));
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
        $this->validate($request, [
            'ans' => "required|min:15",
            'question_id' => 'required|integer'
        ]);

        $answer = Answer::findOrFail($id);
        $answer->ans = $request->ans;
        $answer->user()->associate(Auth::id());

        $question = Question::findOrFail($request->question_id);
        $question->answers()->save($answer);

        return redirect()->route('questions.show', $question->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $answer = Answer::findOrFail($id);
        $answer->delete();
        return redirect()->back();
    }
}
