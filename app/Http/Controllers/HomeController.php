<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     * 
     * Shows each question followed by how many times the user has answered it.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
    
    /**
     * Grabs full report for a user.
     * 
     * @return array $data
     */
    public function getReport() {
        $userId = \Auth::user()->id;
        
        $results = DB::table('user_answers')
                    ->select('questions.question', 'answers.answer', DB::raw('count(answers.id) as count'))
                    ->join('questions', 'user_answers.questions_id','=','questions.id')
                    ->join('answers', 'user_answers.answers_id','=','answers.id')
                    ->where('users_id', $userId)
                    ->groupBy('questions.question', 'answers.answer')
                    ->get()
                    ->toArray();
        
        $data = $this->questionCombine($results);
        return $data;
    }
    
    /*
     * Helper function to combine the answers into one object.
     * Each question can have multiple answers, building an object that reflects that.
     * 
     * @params resultSet from DB.
     * @return Object array of questions + their answers.
     */
    private function questionCombine($results) {
        $report = [];
        $questionTemp = '';
        for($i = 0; $i < count($results); $i++) {
            $answerArray = [
                'answer' => $results[$i]->answer,
                'count' => $results[$i]->count
            ];
            
            //if the question is the same, add the answers to the previous report.
            if($questionTemp == $results[$i]->question) {
                $report[count($report)-1]['answers'][] = $answerArray;
            }
            else {
                $report[] = [
                    'question' => $results[$i]->question,
                    'answers' => [$answerArray]
                ];
            }
            $questionTemp = $results[$i]->question;
        }
        return $report;
    }
}
