<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class MainController extends Controller
{
    private $app_data;

    public function __construct()
    {
        //load app_data.php file froma app folder
        $this->app_data = require(app_path('app_data.php'));

    }

    public function startGame():View
    {
        return view('home');
    }

    public function prepareGame(Request $request)
    {
        //validae request
        $request->validate(
            [
            'total_questions' => 'required|min:3|max:30|integer'
            ],
            [
                'total_questions.required' => 'O número de questões é obrigatório!',
                'total_questions.min' => 'O mínimo é :min questões!',
                'total_questions.max' => 'O máximo é :max questões!',
                'total_questions.integer' => 'O número de questões deve ser inteiro!'
            ]
        );

        //get total quetions
        $total_questions = intval($request->input('total_questions'));

        //prepare all the quiz structure
        $quiz = $this->preparedQuiz($total_questions);

        dd($quiz);


    }

    private function preparedQuiz($total_questions)
    {
        $questions = [];

        $total_countries = count($this->app_data);

        //create countries index for unique questions
        $indexes = range(0, $total_countries, -1);
        shuffle($indexes); //mistura os indices 
        $indexes = array_slice($indexes,0,$total_questions);

        // create arrays of questions
        $question_number = 1;
        foreach($indexes as $index)
        {
            $question['questions_number'] = $question_number++;
            $question['country'] = $this->app_data[$index]['country'];
            $question['correct_answer'] = $this->app_data[$index]['capital'];

            // wrong answers
            $other_capital = array_column($this->app_data,'capital');

            // romove correct answer
            $other_capital = array_diff($other_capital,[$question['correct_answer']]);

            // shuffle the wrong answer
            shuffle($other_capital);
            $question['wrong_answer'] = array_slice($other_capital, 0, 3);

            // store answer result
            $question['correct'] = null;

            $questions[] = $question;
        }

        return $questions;

    }


}
