<?php

namespace App\Http\Controllers\api\V1\auth;

use App\Models\Quiz;
use App\Models\QuizAnswer;
use App\Models\QuizCategory;
use App\Models\QuizQuestion;
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
            $quiz = QuizQuestion::where('id', $request->question_id)->with('answer')->first();
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
    //     $quiz = QuizQuestion::with('answer')->get();
    //     return response()->json($quiz, 200);
    // }

    public function AllQuizCategory(){
        $quizCategoryAll = QuizCategory::with('quiz')->get();
        if($quizCategoryAll == null){
            return response()->json(['message' => 'Quiz Category Not Found'], 200);
        }else{
            foreach($quizCategoryAll as $quizCategory){
                $quizCategoryImg = asset('public/assets/images/quiz/category/' . $quizCategory->image);
                $quizCategory->image = $quizCategoryImg;
                foreach($quizCategory->quiz as $quiz){
                    $quizImg = asset('public/assets/images/quiz/' . $quiz->image);
                    $quiz->image = $quizImg;
                }
            }
            $promo = [];
            $all_category = [];
            foreach($quizCategoryAll as $quizCategory){
                if($quizCategory->id == 1 || $quizCategory->id == 2 || $quizCategory->id == 3){
                    $promo[] = $quizCategory;
                }else {
                    $all_category[] = $quizCategory;
                }
            }
            return response()->json(['promo' => $promo, 'all_category' => $all_category], 200);
        }
    }

    public function QuizCategoryDetail($id){
        $quizCategory = QuizCategory::where('id',$id)->with('quiz')->first();
        if($quizCategory == null){
            return response()->json(['message' => 'Quiz Category Not Found'], 200);
        }else{
            $quizCategoryImg = asset('public/assets/images/quiz/category/' . $quizCategory->image);
            $quizCategory->image = $quizCategoryImg;
            foreach($quizCategory->quiz as $quiz){
                $quizImg = asset('public/assets/images/quiz/' . $quiz->image);
                $quiz->image = $quizImg;
            }
            return response()->json($quizCategory, 200);
        }
    }

    public function Quiz($id){
        $quiz = Quiz::where('id',$id)->with('quiz_question.answer')->first();
        if($quiz == null){
            return response()->json(['message' => 'Quiz Not Found'], 200);
        }else{
            $quizImg = asset('public/assets/images/quiz/' . $quiz->image);
            $quiz->image = $quizImg;
            foreach($quiz->quiz_question as $question){
                if($question->image != null){
                $questionImg = asset('public/assets/images/quiz/question/' . $question->image);
                $question->image = $questionImg;
                }
            }
            return response()->json($quiz, 200);
        }
    }
}
