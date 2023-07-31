<?php

namespace App\Http\Controllers\Training;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    //

    public function traininghome(){
        
        return view('training.traininghome');
        
    }

    public function trainingsetup(){
        return view('training.training-setup');
    }

    public function trainingplan(){
        return view('training.training-plan');
    }

    public function trainingexecute(){
        return view('training.training-execute');
    }

    public function traininganalyze(){
        return view('training.training-analyze');
    }
}
