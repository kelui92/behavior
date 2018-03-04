<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

use App\Question;
use App\Answer;
use App\UserAnswer;

class QuestionController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('question');
    }
    
    /*
     * Main api call for getting 3 random questions.
     * 
     * @return: returns a structured object of questions and answers
     */
    public function getRandomQuestions() {
        $questionsAnswers = [];
        
        /*
         * Grab 3 random questions
         */
        $questions = Question::select('id','question')
                                ->orderByRaw('RAND()')
                                ->limit(3)
                                ->get()
                                ->toArray();
        
        /*
         * Grab the answers for each question.
         */
        foreach($questions as $question) {
            $answers = Answer::select('id','answer')
                                ->where('questions_id', $question['id'])
                                ->get()
                                ->toArray();
            
            //building structure for frontend.
            $question['answers'] = $answers;
            $question['picked'] = '';
            $questionsAnswers[] = $question;
        }
        return $questionsAnswers;
    }
    
    /*
     * API Call for answering questions
     */
    public function answerQuestions(Request $request) {
        $userId = \Auth::user()->id;
        
        $qaPair = $request->all();
        try {
            foreach($qaPair as $qa) {
                $userAnswerObj = new UserAnswer();
                $userAnswerObj->users_id = $userId;
                $userAnswerObj->questions_id = $qa['question'];
                $userAnswerObj->answers_id = $qa['answer'];
                $userAnswerObj->save();
            }

            return ['success' => true];
        } catch (Exception $ex) {
            return ['success' => false, 'message' => 'Form is invalid, please try again'];
        }
        
    }
}
