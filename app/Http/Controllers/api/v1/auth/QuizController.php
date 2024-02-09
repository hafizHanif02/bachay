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
    public function submitQuiz(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $child = FamilyRelation::where(['id' => $request->child_id, 'user_id' => $user->id])->first();
            $quiz = Quiz::where('id', $request->quiz_id)->with('quiz_question')->first();
            dd($request->answer[2]);
            if ($child !== null) {
                if ($quiz !== null) {
                    $questionIds = $quiz->quiz_question->pluck('id')->all();

                    $submissionData = [];
                    foreach ($questionIds as $index => $questionId) {
                        $submissionData[] = [
                            'question_id' => $questionId,
                            'answer' => $request->answer[$index] ?? null,
                        ];
                    }
    
                    return response()->json([
                        'submission_data' => $submissionData,
                        'message' => translate('Quiz submitted successfully.'),
                    ], 200);
                } else {
                    return response()->json(['errors' => translate('Quiz not found.')], 404);
                }
            } else {
                return response()->json(['errors' => translate('Child not found or unauthorized.')], 401);
            }
        } else {
            return response()->json(['errors' => translate('Please log in first.')], 401);
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
