<?php

namespace App\Http\Controllers\api\V1\auth;

use App\Models\Quiz;
use App\Models\QuizAnswer;
use App\Models\QuizCategory;
use Illuminate\Http\Request;
use App\Models\familyRelation;
use App\Models\QuizSubmission;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function SubmitQuiz(Request $request)
    {
        if(Auth::check()){
            $user = Auth::user();
            $child = familyRelation::where(['id'=> $request->child_id, 'user_id' => $user->id])->first();
            $quiz = Quiz::where('id', $request->quiz_id)->with('answer')->first();
            $quizanswer = QuizAnswer::where('id', $request->answer_id)->first();
            if($child != null){
                $quizsubmission = new QuizSubmission();
                $quizsubmission->quiz_id = $quiz->id;
                $quizsubmission->child_id = $child->id;
                $quizsubmission->user_id = $user->id;
                $quizsubmission->answer_id = $request->answer_id;
                $quizsubmission->save();
                return response()->json(['message' => 'Quiz Submitted Successfully'], 200);
            }else{
                return response()->json(['errors' => translate('Child Not Found!')], 401);
            }
        }else{
            return response()->json(['errors' => translate('Please login first!')], 401);
        }
    }

    // public function AllQuiz(){
    //     $quiz = Quiz::with('answer')->get();
    //     return response()->json($quiz, 200);
    // }

    public function AllQuizCategory(){
        $quizCategoryAll = QuizCategory::get();
        if($quizCategoryAll == null){
            return response()->json(['message' => 'Quiz Category Not Found'], 200);
        }else{
            foreach($quizCategoryAll as $quizCategory){
                $quizCategoryImg = asset('public/assets/images/quiz/category/' . $quizCategory->image);
                $quizCategory->image = $quizCategoryImg;
            }
            return response()->json($quizCategoryAll, 200);
        }
    }

    public function QuizCategoryDetail($id){
        $quizCategory = QuizCategory::where('id',$id)->with('quiz')->first();
        if($quizCategory == null){
            return response()->json(['message' => 'Quiz Category Not Found'], 200);
        }else{
            $quizCategoryImg = asset('public/assets/images/quiz/category/' . $quizCategory->image);
            $quizCategory->image = $quizCategoryImg;
            return response()->json($quizCategory, 200);
        }
    }

    public function Quiz($id){
        $quiz = Quiz::where('id',$id)->with('answer')->first();
        if($quiz == null){
            return response()->json(['message' => 'Quiz Not Found'], 200);
        }else{
            return response()->json($quiz, 200);
        }
    }
}
