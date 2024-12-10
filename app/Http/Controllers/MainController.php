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

    }


}
