<?php

namespace App\Http\Controllers\Api\V1;

use App\User;
use DateTime;
use Carbon\Carbon;
use App\CPU\Helpers;
use App\Model\Order;
use App\Model\QuizSubmission;
use App\Models\Growth;
use App\Model\Wishlist;
use App\Model\GuestUser;
use App\CPU\ImageManager;
use App\Models\QnaAnswer;
use App\Model\OrderDetail;
use App\Models\QnaQuestion;
use App\Models\Vaccination;
use App\Traits\CommonTrait;
use App\CPU\CustomerManager;
use App\Model\SupportTicket;
use Illuminate\Http\Request;
use App\Model\DeliveryZipCode;
use App\Model\ShippingAddress;
use App\Models\familyRelation;
use function App\CPU\translate;
use App\Model\SupportTicketConv;
use App\Model\DeliveryCountryCode;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\VaccinationSubmission;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    use CommonTrait;
    public function info(Request $request)
    {
        $user = $request->user();
        $referral_user_count = User::where('referred_by', $user->id)->count();
        $user->referral_user_count = $referral_user_count;
        if($user->image != null){
            $documentRoot = $_SERVER['DOCUMENT_ROOT'];
            $scriptName = $_SERVER['SCRIPT_NAME'];
            $currentPath = str_replace(basename($scriptName), '', $documentRoot . $scriptName);
            $url = 'http://' . $_SERVER['HTTP_HOST'] . str_replace($documentRoot, '', $currentPath) . '/public/assets/images/customers/' . $user['image'];
            $user->avatar = $url;
        }else{
            $user->avatar = null;
        }

        $user->orders_count = User::withCount('orders')->find($user->id)->orders_count;
        

        return response()->json(['user' => $user], 200);
    }

    public function AddAdress(Request $request){
        if(Auth::check()){
            DB::table('shipping_addresses')->where('customer_id', Auth::user()->id)->update([
                'is_default' => 'false'
            ]);
            $validator = Validator::make($request->all(), [
                'contact_person_name' => 'required',
                'address_type' => 'required',
                'appartment_no' => 'nullable|required_without:house_no',
                'house_no' => 'nullable|required_without:appartment_no',
                'street_address' => 'required',
                'city' => 'required',
                'state' => 'required',
                'zip' => 'required',
                'phone' => 'required',
                'state' => 'required',
                'country' => 'required',
                'is_default' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => Helpers::error_processor($validator)], 403);
            }
            else{
            $customer_data = DB::table('users')->where('id', Auth::user()->id)->first();
            if($customer_data){
                DB::table('shipping_addresses')->insert([
                    'customer_id' => $customer_data->id,
                    'contact_person_name' => ($request->contact_person_name) ? $request->contact_person_name : ($customer_data->f_name.' '.$customer_data->l_name),
                    'email' => $customer_data->email,
                    'address_type' => $request->address_type,
                    'address' => ($request->appartment_no ?? '').' '.($request->house_no ?? '').' '.($request->street_address ?? '').' '.($request->city ?? '').', '.($request->state ?? '').' '.($request->country ?? ''),
                    'is_default' => $request->is_default,
                    'appartment_no' => $request->appartment_no,  
                    'street_address' => $request->street_address,  
                    'city' => $request->city,
                    'zip' => $request->zip,
                    'phone' => $request->phone,
                    'state' => $request->state,
                    'country' => $request->country,
                ]);
                if($request->is_default == true){
                    DB::table('users')->where('id', Auth::user()->id)->update([
                        'street_address' => $request->street_address,
                        'country' => $request->country,
                        'zip' => $request->zip,
                        'house_no' => $request->house_no,
                        'apartment_no' => $request->appartment_no,
                        'city' => $request->city,
                    ]);
                }
                return response()->json(['message' => 'Address Has Been Saved'], 404);
            }else{
                return response()->json(['message' => 'Customer not found'], 404);
            }
        }
        }else{
            return response()->json(['message' => 'Please Login First'], 404);
        }
    } 

    public function GetAdress($id){
        $shipping_address = DB::table('shipping_addresses')->where('id',$id)->first();
        if($shipping_address){
            return response()->json($shipping_address, 200);
        }else{
            return response()->json(['message' => 'Address Not Found'], 404);
        }
    }

    public function Address(){
        if(Auth::user()){
            $addresses = DB::table('shipping_addresses')->where('customer_id', Auth::user()->id)->get();
            if($addresses->isNotEmpty()){
                return response()->json($addresses, 200);
            }else{
                return response()->json(['message' => 'Address Not Found'], 404);
            }
        }else{
            return response()->json(['message' => 'Please Login First'], 404);
        }
    }

    public function Mychild(){
        if(Auth::user()){
            $childerens = DB::table('family_relation')->where('user_id', Auth::user()->id)->get();
            foreach($childerens as $child){
                if($child->profile_picture != null){
                $childImageUrl = url('public/assets/images/customers/child/' . $child->profile_picture);
                $child->avatar = $childImageUrl;
                }
            }
            $overdueCounts = [];
            foreach ($childerens as $child) {
                $vaccination_submissions = VaccinationSubmission::
                    where([
                        'child_id' => $child->id, 
                        'user_id' => Auth::user()->id,
                        'is_taken' => 0
                    ])->with('vaccination')->get();

                $vaccination_submission_completed = VaccinationSubmission::
                where([
                    'child_id' => $child->id, 
                    'user_id' => Auth::user()->id,
                    'is_taken' => 1
                ])->with('vaccination')->get();
            
                $child->vaccination = $vaccination_submissions;
                $overdue = 0;
                $uppcoming = 0;
                $today = 0;
                foreach ($vaccination_submissions as $vaccination_submission) {
                    $vaccinationDate = Carbon::parse($vaccination_submission->vaccination_date);
                    $difference = -($vaccinationDate->diffInMonths(now(), false));
                    if ($difference < 0) {
                        $overdue += 1;
                    } elseif ($difference > 0) {
                        $uppcoming += 1;
                    } elseif ($difference == 0 && $vaccinationDate->isSameDay(now())) {
                        $today += 1;
                    }
                }
                $child->vaccination_status = ['uppcoming' => $uppcoming,'today' =>  $today,'overdue' =>   $overdue,'completed' => count($vaccination_submission_completed)];
            }
            return response()->json($childerens, 200);
        }else{
            return response()->json(['message' => 'Please Login First'], 404);
        }
    }

    public function Addchild(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'relation_type' => 'required',
            'dob' => 'required',
            'gender' => 'required',
            'profile_picture' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }else{
            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $extension = $file->getClientOriginalExtension();
                $filename = $file->getClientOriginalName();
                $file->move(public_path('assets/images/customers/child'), $filename);
            } else {
                $filename = null;
            }
            $childId = DB::table('family_relation')->insertGetId([
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'relation_type' => $request->relation_type,
                'dob' => $request->dob,
                'gender' => $request->gender,
                'profile_picture' => ($filename ?? ''),
            ]);
            $Vaccinations = Vaccination::get();
            foreach($Vaccinations as $vaccination){
                $dateOfBirth = $request->dob;
                $carbonDateOfBirth = Carbon::parse($dateOfBirth);
                $resultDate = $carbonDateOfBirth->addMonths($vaccination->age)->toDateString();
                VaccinationSubmission::create([
                    'user_id' => Auth::user()->id,
                    'child_id' => $childId,
                    'vaccination_id' => $vaccination->id,
                    'vaccination_date' => $resultDate,
                ]);
                Growth::create([
                    'user_id' => Auth::user()->id,
                    'child_id' => $childId,
                    'vaccination_id' => $vaccination->id,
                ]);
            }
            return response()->json(['message' => 'Child Has Been Added'], 403);
            
        }
    }

    public function GrowthGet($id){
        $growth = Growth::where('id',$id)->first();
        return response()->json($growth, 403);
    }

    public function GrowthUpdate(Request $request,$id){
        Growth::where('id',$id)->update([
            'head_circle' => $request->head_circle,
            'height' => $request->height,
            'weight' => $request->weight,
        ]);
        return response()->json('Growth Data Has Been Added', 403);
    }

    public function Vaccination($id){
        $growth = VaccinationSubmission::where('id',$id)->first();
        return response()->json($growth, 403);
    }

    public function VaccinationSubmission(Request $request,$id){
        if ($request->hasFile('picture')) {
            $file = $request->file('picture');
            $extension = $file->getClientOriginalExtension();
            $filename = $file->getClientOriginalName();
            $file->move(public_path('assets/images/customers/child/vaccination'), $filename);
        VaccinationSubmission::where('id',$id)->update([
            'submission_date' => now(),
            'is_taken' => 1,
            'picture' => $filename,
        ]);
        return response()->json('Vaccination Has Been Added', 403);
    }
}

public function SubmitQuiz(Request $request){
    if(Auth::check()){
        $validator = QuizSubmission::make($request->all(), [
            'child_id' => 'required|exists:family_relation,id',
            'quiz_id' => 'required|exists:quiz,id',
            'answer_id' => 'required|exists:quiz_answer,id',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        QuizSubmisSubmitQuizsion::create([
            'user_id' => Auth::user()->id,
            'child_id' => $request->child_id,
            'quiz_id' => $request->quiz_id,
            'answer_id' => $request->answer_id,
        ]);
        return response()->json(['message' => 'Quiz Has Been Submitted!'], 403);

    }else{
        return response()->json(['errors' => 'Please Login First !'], 403);
    }

}


    public function AllQuestion()
    {
        $questions = QnaQuestion::with('answers.user', 'user')->get();
        //return $question;
    
        if ($questions->isNotEmpty()) {
            foreach ($questions as $question) {
                if ($question->user->image != null) {
                    $questionImageUrl = asset('public/assets/images/customers/' . $question->user->image);
                    $question->user->avatar = $questionImageUrl;
                }
    
                foreach ($question->answers as $answer) {
                    if ($answer->user->image != null) {
                        $answerImageUrl = asset('public/assets/images/customers/' . $answer->user->image);
                        $answer->user->avatar = $answerImageUrl;
                    }
                }
            }
            return response()->json($questions, 200);
        } else {
            return response()->json(['message' => 'Question Not Found'], 404);
        }
    }
    
    
    public function AddQuestion(Request $request){
        if(Auth::check()){
            $validator = Validator::make($request->all(), [
                'question' => 'required',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => Helpers::error_processor($validator)], 403);
            }else{
                QnaQuestion::create([
                    'user_id' => Auth::user()->id,
                    'question' => $request->question,
                ]);
                return response()->json(['message' => 'Question Has Been Added'], 403);
                
            }
        }
        else{
            return response()->json(['message' => 'Please Login First'], 404);
        }
    }

    public function AddAnswer(Request $request){
        if(Auth::check()){
            $validator = Validator::make($request->all(), [
                'question_id' => 'required|exists:qna_question,id',
                'answer' => 'required',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['errors' => Helpers::error_processor($validator)], 403);
            }else{
                QnaAnswer::create([
                    'question_id' => $request->question_id,
                    'answer' => $request->answer,
                    'user_id' => Auth::user()->id,
                ]);
                return response()->json(['message' => 'Answer Has Been Added'], 403);
                
            }
        }
        else{
            return response()->json(['message' => 'Please Login First'], 404);
        }
    }

    public function Detailchild($id){
        $child = DB::table('family_relation')->where('id', $id)->first();
               

        $childDob = new DateTime($child->dob);
        $today = new DateTime();
        $interval = $today->diff($childDob);
        $years = $interval->y;
        $months = $interval->m;
        $days = $interval->d;
        $ageInWords = '';
        if ($years > 0) {
            $ageInWords .= $years . ' Year' . ($years > 1 ? 's' : '');
        }
        if ($months > 0) {
            $ageInWords .= ($ageInWords ? ' ' : '') . $months . ' Month' . ($months > 1 ? 's' : '');
        }
        if ($days > 0) {
            $ageInWords .= ($ageInWords ? ' ' : '') . $days . ' Day' . ($days > 1 ? 's' : '');
        }
        $child->age = $ageInWords;

        

        $vaccinations = VaccinationSubmission::where(['child_id'=> $id, 'user_id' => Auth::user()->id])->with('vaccination')->get();
        if($child != null){
            if($child->profile_picture != null){
            $childImageUrl = url('public/assets/images/customers/child/' . $child->profile_picture);
                $child->avatar = $childImageUrl;
            }

            $vaccines = Vaccination::orderByRaw('CAST(age AS SIGNED) ASC')->get();
            
            $vaccination_data = [];
            
                foreach ($vaccines as $vaccine) {
                    $vaccineSubmission = VaccinationSubmission::where(['child_id' => $child->id, 'vaccination_id' => $vaccine->id])->get();
                    if (!isset($vaccination_data[$vaccine->age])) {
                        $vaccination_data[$vaccine->age] = [];
                    }
                    $vaccination_data[$vaccine->age][] = array_merge($vaccine->toArray(), ['vaccine_submission' => $vaccineSubmission->toArray()]);

                    $child->vaccination = $vaccination_data;
                }
            
                $dates = [];
                foreach ($vaccination_data as $month) {
                    foreach ($month as $vac) {
                        $dob = Carbon::parse($child->dob);
                        $vaccinationDate = Carbon::parse($vac['vaccine_submission'][0]['vaccination_date']);
                        $dateDifference = $dob->diffInMonths($vaccinationDate);
                        $dates[] = $dateDifference;
                    }
                }

                // Statuses 
                    $vaccination_submissions = VaccinationSubmission::
                        where([
                            'child_id' => $child->id, 
                            'user_id' => Auth::user()->id,
                            'is_taken' => 0
                        ])->with('vaccination')->get();
    
                    $vaccination_submission_completed = VaccinationSubmission::
                    where([
                        'child_id' => $child->id, 
                        'user_id' => Auth::user()->id,
                        'is_taken' => 1
                    ])->with('vaccination')->get();
                
                    $overdue = 0;
                    $uppcoming = 0;
                    $today = 0;
                    foreach ($vaccination_submissions as $vaccination_submission) {
                        $vaccinationDate = Carbon::parse($vaccination_submission->vaccination_date);
                        $difference = -($vaccinationDate->diffInMonths(now(), false));
                        if ($difference < 0) {
                            $overdue += 1;
                        } elseif ($difference > 0) {
                            $uppcoming += 1;
                        } elseif ($difference == 0 && $vaccinationDate->isSameDay(now())) {
                            $today += 1;
                        }
                    }
                    $child->vaccination_status = ['uppcoming' => $uppcoming,'today' =>  $today,'overdue' =>   $overdue,'completed' => count($vaccination_submission_completed)];

            return response()->json($child, 200);
        }else{
            return response()->json(['message' => 'Child Not Found'], 404);
        }
    }

    public function Updatechild(Request $request,$id){
        if(Auth::check()){
            $child = DB::table('family_relation')->where('id', $id)->first();
            if(!empty($child)){
                if ($request->hasFile('profile_picture')) {
                    $file = $request->file('profile_picture');
                    $extension = $file->getClientOriginalExtension();
                    $filename = $file->getClientOriginalName();
                    $file->move(public_path('assets/images/customers/child'), $filename);
                } else {
                    $filename = null;
                }
                DB::table('family_relation')->where('id', $id)->update([
                    'relation_type' => $request->relation_type,
                    'dob' => $request->dob,
                    'gender' => $request->gender,
                    'name' => $request->name,
                    'profile_picture' => $filename,
                ]);
                return response()->json(['message' => 'Child Has Been Updated'], 200);
            }else{
                 return response()->json(['message' => 'Child Not Found'], 200);
            }
        }else{
            return response()->json(['message' => 'Please Login First'], 404);
        }
    }

    public function Deletechild($id){
        $child = DB::table('family_relation')->where('id', $id)->first();
        if($child){
            DB::table('family_relation')->where('id', $id)->delete();
            return response()->json(['message' => 'Child Has Been Deleted'], 200);
        }else{
            return response()->json(['message' => 'Child Not Found'], 200);
        }
    }


    public function UpdateAdress(Request $request, $id){
        if(Auth::check()){
            $address = DB::table('shipping_addresses')->where(['customer_id'=> Auth::user()->id,'id'=>$id])->first();
            if(!empty($address)){
                
                DB::table('shipping_addresses')->where(['customer_id'=> Auth::user()->id,'id'=>$id])->update([
                    'is_default' => 'false'
                ]);
                DB::table('shipping_addresses')->where('id' , $request->id)->update([
                    'customer_id' => Auth::user()->id,
                    'contact_person_name' => $request->contact_person_name,
                    'email' => $request->email,
                    'address_type' => $request->address_type,
                    'address' => ($request->apartment_no ?? '').' '.($request->house_no ?? '').' '.($request->street_address ?? '').' '.($request->city ?? '').', '.($request->state ?? '').' '.($request->country ?? ''),
                    'is_default' => $request->is_default,
                    'appartment_no' => $request->appartment_no,  
                    'street_address' => $request->street_address, 
                    'city' => $request->city,
                    'zip' => $request->zip,
                    'phone' => $request->phone,
                    'state' => $request->state,
                    'country' => $request->country,
                ]);
                if($request->is_default == true){
                    DB::table('users')->where('id', Auth::user()->id)->update([
                        'street_address' => $request->street_address,
                        'country' => $request->country,
                        'zip' => $request->zip,
                        'house_no' => $request->house_no,
                        'apartment_no' => $request->appartment_no,
                        'city' => $request->city,
                    ]);
                }
                return response()->json(['message' => 'Address Has Been Updated'], 404);
            }else{
                return response()->json(['message' => 'Address Not Found!'], 404);
            }
        } else {
            return response()->json(['message' => 'Please Login First'], 404);
        }
    }
    

    public function DeleteAddress($id)
    {
        $affectedRows = DB::table('shipping_addresses')->where('id', $id)->delete();

        if ($affectedRows > 0) {
            return response()->json(['message' => 'Address has been deleted'], 200);
        } else {
            return response()->json(['message' => 'Address not found'], 404);
        }
    }

    public function create_support_ticket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required',
            'type' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $image = [] ;
        if ($request->file('image')) {
            foreach ($request->image as $key=>$value) {
                $image_name = ImageManager::upload('support-ticket/', 'webp', $value);
                $image[] = $image_name;
            }
        }

        $request['customer_id'] = $request->user()->id;
        $request['status'] = 'pending';
        $request['attachment'] = json_encode($image);

        try {
            CustomerManager::create_support_ticket($request);
        } catch (\Exception $e) {
            return response()->json([
                'errors' => [
                    'code' => 'failed',
                    'message' => 'Something went wrong',
                ],
            ], 422);
        }
        return response()->json(['message' => 'Support ticket created successfully.'], 200);
    }
    public function account_delete(Request $request, $id)
    {
        if($request->user()->id == $id)
        {
            $user = User::find($id);

            $ongoing = ['out_for_delivery','processing','confirmed', 'pending'];
            $order = Order::where('customer_id', $user->id)->whereIn('order_status', $ongoing)->count();
            if($order>0){
                return response()->json(['message' =>'You can`t delete account due ongoing_order!!'],403);
            }

            ImageManager::delete('/profile/' . $user['image']);

            $user->delete();
           return response()->json(['message' => translate('Your_account_deleted_successfully!!')],200);

        }else{
            return response()->json(['message' =>'access_denied!!'],403);
        }
    }

    public function ChangeAvatar(Request $request){

        
        if(isset(auth()->user()->image)) {
            // $avatarPath = $request->file('avatar')->store('customers', 'public');
            Storage::disk('public')->delete('assets/images/customers/'.auth()->user()->image);
        }
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $extension = $file->getClientOriginalExtension();
            $filename = $file->getClientOriginalName();
            $picture = $request->avatar->move(public_path('assets/images/customers'), $filename);
            
            
            DB::table('users')->where(['id' => auth()->user()->id])->update([
                'image' => $filename,
            ]);
    
            return response()->json([
                'message' => 'Avatar change successfully',
            ], 200);
        }else {
            return response()->json(['error' => 'No file uploaded.'], 400);
        }
        

    }

    public function reply_support_ticket(Request $request, $ticket_id)
    {
        DB::table('support_tickets')->where(['id' => $ticket_id])->update([
            'status' => 'open',
            'updated_at' => now(),
        ]);

        $image = [] ;
        if ($request->file('image')) {
            foreach ($request->image as $key=>$value) {
                $image_name = ImageManager::upload('support-ticket/', 'webp', $value);
                $image[] = $image_name;
            }
        }

        $support = new SupportTicketConv();
        $support->support_ticket_id = $ticket_id;
        $support->attachment = json_encode($image);
        $support->admin_id = 0;
        $support->customer_message = $request['message'];
        $support->save();
        return response()->json(['message' => 'Support ticket reply sent.'], 200);
    }

    public function get_support_tickets(Request $request)
    {
        return response()->json(SupportTicket::where('customer_id', $request->user()->id)->get(), 200);
    }

    public function get_support_ticket_conv($ticket_id)
    {
        $conversations = SupportTicketConv::where('support_ticket_id', $ticket_id)->get();
        $support_ticket = SupportTicket::find($ticket_id);

        $conversations->map(function ($conversation) {
            $conversation->attachment = json_decode($conversation->attachment);
        });

        $conversations = $conversations->toArray();

        if($support_ticket){
            $description = array(
                'support_ticket_id'=>$ticket_id,
                'admin_id'=>null,
                'customer_message'=>$support_ticket->description,
                'admin_message'=>null,
                'attachment'=>json_decode($support_ticket->attachment),
                'position'=>0,
                'created_at'=>$support_ticket->created_at,
                'updated_at'=>$support_ticket->updated_at,
            );
            array_unshift($conversations, $description);
        }
        return response()->json($conversations, 200);
    }

    public function support_ticket_close($id)
    {
        $ticket = SupportTicket::find($id);
        if($ticket){
            $ticket->status = 'close';
            $ticket->updated_at = now();
            $ticket->save();
            return response()->json(['message' => 'Successfully close the ticket'], 200);
        }
        return response()->json(['message' => 'Ticket not found'], 403);
    }

    public function add_to_wishlist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $wishlist = Wishlist::where('customer_id', $request->user()->id)->where('product_id', $request->product_id)->first();

        if (empty($wishlist)) {
            $wishlist = new Wishlist;
            $wishlist->customer_id = $request->user()->id;
            $wishlist->product_id = $request->product_id;
            $wishlist->save();
            return response()->json(['message' => translate('successfully added!')], 200);
        }

        return response()->json(['message' => translate('Already in your wishlist')], 409);
    }

    public function remove_from_wishlist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $wishlist = Wishlist::where('customer_id', $request->user()->id)->where('product_id', $request->product_id)->first();

        if (!empty($wishlist)) {
            Wishlist::where(['customer_id' => $request->user()->id, 'product_id' => $request->product_id])->delete();
            return response()->json(['message' => translate('successfully removed!')], 200);

        }
        return response()->json(['message' => translate('No such data found!')], 404);
    }

    public function wish_list(Request $request)
    {

        $wishlist = Wishlist::whereHas('wishlistProduct',function($q){
            return $q;
        })->with(['product_full_info'])->where('customer_id', $request->user()->id)->get();

        $wishlist->map(function ($data) {
            $data['product_full_info'] = Helpers::product_data_formatting(json_decode($data['product_full_info'], true));
            return $data;
        });

        return response()->json($wishlist, 200);
    }

    public function address_list(Request $request)
    {
        $user = Helpers::get_customer($request);
        if($user == 'offline'){
            $data = ShippingAddress::where(['customer_id'=> $request->guest_id, 'is_guest'=>1])->latest()->get();
        }else{
            $data = ShippingAddress::where(['customer_id'=> $user->id, 'is_guest'=>'0'])->latest()->get();
        }
        return response()->json($data, 200);
    }

    public function add_new_address(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contact_person_name' => 'required',
            'address_type' => 'required',
            'address' => 'required',
            'city' => 'required',
            'zip' => 'required',
            'country' => 'required',
            'phone' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'is_billing' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $zip_restrict_status = Helpers::get_business_settings('delivery_zip_code_area_restriction');
        $country_restrict_status = Helpers::get_business_settings('delivery_country_restriction');

        if ($country_restrict_status && !self::delivery_country_exist_check($request->input('country'))) {
            return response()->json(['message' => translate('Delivery_unavailable_for_this_country')], 403);

        } elseif ($zip_restrict_status && !self::delivery_zipcode_exist_check($request->input('zip'))) {
            return response()->json(['message' => translate('Delivery_unavailable_for_this_zip_code_area')], 403);
        }

        $user = Helpers::get_customer($request);

        $address = [
            'customer_id' => $user=='offline' ? $request->guest_id : $user->id,
            'is_guest' => $user == 'offline' ? 1 : 0,
            'contact_person_name' => $request->contact_person_name,
            'address_type' => $request->address_type,
            'address' => $request->address,
            'city' => $request->city,
            'zip' => $request->zip,
            'country' => $request->country,
            'phone' => $request->phone,
            'email' => $request->email,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'is_billing' => $request->is_billing,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        ShippingAddress::insert($address);
        return response()->json(['message' => translate('successfully added!')], 200);
    }

    public function update_address(Request $request)
    {

        $shipping_address = ShippingAddress::where(['customer_id' => $request->user()->id, 'id' => $request->id])->first();
        if (!$shipping_address) {
            return response()->json(['message' => translate('not_found')], 200);
        }

        $zip_restrict_status = Helpers::get_business_settings('delivery_zip_code_area_restriction');
        $country_restrict_status = Helpers::get_business_settings('delivery_country_restriction');

        if ($country_restrict_status && !self::delivery_country_exist_check($request->input('country'))) {
            return response()->json(['message' => translate('Delivery_unavailable_for_this_country')], 403);

        } elseif ($zip_restrict_status && !self::delivery_zipcode_exist_check($request->input('zip'))) {
            return response()->json(['message' => translate('Delivery_unavailable_for_this_zip_code_area')], 403);
        }

        $user = Helpers::get_customer($request);

        $shipping_address->update([
                'customer_id' => $user=='offline' ? $request->guest_id : $user->id,
                'is_guest' => $user == 'offline' ? 1 : 0,
                'contact_person_name' => $request->contact_person_name,
                'address_type' => $request->address_type,
                'address' => $request->address,
                'city' => $request->city,
                'zip' => $request->zip,
                'country' => $request->country,
                'phone' => $request->phone,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'is_billing' => $request->is_billing,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        return response()->json(['message' => translate('update_successful')], 200);
    }

    public function delete_address(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $user = Helpers::get_customer($request);

        $shipping_address = ShippingAddress::where(['id' => $request['address_id']])
            ->when($user=='offline', function($query) use($request){
                $query->where(['customer_id' => $request->guest_id ,'is_guest'=>1]);
            })
            ->when($user!='offline', function($query) use($user){
                $query->where(['customer_id' => $user->id,'is_guest'=>'0']);
            })->first();

        if ($shipping_address && $shipping_address->delete()) {
            return response()->json(['message' => 'successfully removed!'], 200);
        }
        return response()->json(['message' => translate('No such data found!')], 404);
    }

    public function get_order_list(Request $request)
    {
        $status = array(
            'ongoing' => ['out_for_delivery','processing','confirmed', 'pending'],
            'canceled' => ['canceled','failed','returned'],
            'delivered' => ['delivered'],
        );
        if($request->filter){
            $orders = Order::with('details.product','delivery_man', 'seller.shop')->where('order_status' , $request->filter['status'])
                ->withSum('details as order_details_count', 'qty')
                ->where(['customer_id' => $request->user()->id, 'is_guest'=>'0'])
                ->when($request->status && $request->status != 'all', function ($query) use($request, $status){
                    $query->whereIn('order_status', $status[$request->status])
                    ->when($request->type == 'reorder', function($query) use($request){
                        $query->where('order_type', 'default_type');
                    });
                })
                ->latest()
                ->paginate($request['limit'], ['*'], 'page', $request['offset']);
        }else{
            $orders = Order::with('details.product','delivery_man', 'seller.shop')
                ->withSum('details as order_details_count', 'qty')
                ->where(['customer_id' => $request->user()->id, 'is_guest'=>'0'])
                ->when($request->status && $request->status != 'all', function ($query) use($request, $status){
                    $query->whereIn('order_status', $status[$request->status])
                    ->when($request->type == 'reorder', function($query) use($request){
                        $query->where('order_type', 'default_type');
                    });
                })
                ->latest()
                ->paginate($request['limit'], ['*'], 'page', $request['offset']);
        }

        foreach ($orders as $order) {
            foreach ($order->details as $detail) {
                $thumbnailUrl = $detail['product']->thumbnail;
                $filename = basename($thumbnailUrl);
                $newThumbnailUrl = asset('storage/app/public/product/thumbnail/' . $filename);
                $detail['product']->thumbnail = $newThumbnailUrl;
            }
        }

        $orders->map(function ($data) {
            $data['shipping_address_data'] = json_decode($data['shipping_address_data']);
            $data['billing_address_data'] = json_decode($data['billing_address_data']);
            $data->details->map(function ($query) {
                $query['product'] = Helpers::product_data_formatting(json_decode($query['product'], true));
                return $query;
            });

        });

        $orders = [
            'total_size' => $orders->total(),
            'limit' => $request['limit'],
            'offset' => $request['offset'],
            'orders' => $orders->items()
        ];
        return response()->json($orders, 200);
    }

    public function get_order_details(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $user = Helpers::get_customer($request);

        $details = OrderDetail::with('order.delivery_man','verification_images','seller.shop')
            ->whereHas('order',function($query) use($request, $user){
                $query->where([
                    'customer_id'=> $user=='offline' ? $request->guest_id : $user->id,
                    'is_guest'=>$user=='offline' ? 1 : '0'
                ]);
            })
            ->where(['order_id' => $request['order_id']])
            ->get();
        $details->map(function ($query) {
            $query['variation'] = json_decode($query['variation'], true);
            $query['product_details'] = Helpers::product_data_formatting(json_decode($query['product_details'], true));
            return $query;
        });
        return response()->json($details, 200);
    }

    public function get_order_by_id(Request $request,$id)
    {
        // $validator = Validator::make($request->all(), [
        //     'order_id' => ['required','exists:orders,id'],
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        // }

        $order = Order::withCount('order_details')->with(['details.product','delivery_man','offline_payments','verification_images'])->where(['id' => $id])->first();

        foreach($order->details as $detail){
            $thumbnailUrl = $detail['product']->thumbnail;
            $filename = basename($thumbnailUrl);
            $newThumbnailUrl = asset('storage/app/public/product/thumbnail/' . $filename);
            $detail['product']->thumbnail = $newThumbnailUrl;
        }
        if($order != null) {
            $order->no_of_items = $order->order_details_count;
            // if(isset($order['offline_payments'])){
            //     $order['offline_payments']->payment_info = json_decode($order->offline_payments->payment_info);
            // }
            // $order['shipping_address_data'] = json_decode($order['shipping_address_data']);
            // $order['billing_address_data'] = json_decode($order['billing_address_data']);
            return response()->json($order, 200);
        }else{
            return response()->json(['message' => translate('Order Not Found found!')], 404);
        }
    }

    public function update_profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'f_name' => 'required',
            'l_name' => 'required',
            'phone' => 'required',
        ], [
            'f_name.required' => translate('First name is required!'),
            'l_name.required' => translate('Last name is required!'),
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        if ($request->has('image')) {
            $imageName = ImageManager::update('profile/', $request->user()->image, 'webp', $request->file('image'));
        } else {
            $imageName = $request->user()->image;
        }

        if ($request['password'] != null && strlen($request['password']) > 5) {
            $pass = bcrypt($request['password']);
        } else {
            $pass = $request->user()->password;
        }

        $userDetails = [
            'f_name' => $request->f_name,
            'l_name' => $request->l_name,
            'phone' => $request->phone,
            'image' => $imageName,
            'password' => $pass,
            'updated_at' => now(),
        ];

        User::where(['id' => $request->user()->id])->update($userDetails);

        return response()->json(['message' => translate('successfully updated!')], 200);
    }

    public function update_cm_firebase_token(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cm_firebase_token' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $user = Helpers::get_customer($request);

        if($user == 'offline') {
            $guest = GuestUser::find($request->guest_id);
            $guest->fcm_token = $request['cm_firebase_token'];
            $guest->save();
        }else{
            DB::table('users')->where('id', $user->id)->update([
                'cm_firebase_token' => $request['cm_firebase_token'],
            ]);
        }

        return response()->json(['message' => translate('successfully updated!')], 200);
    }

    public function get_restricted_country_list(Request $request)
    {
        $stored_countries = DeliveryCountryCode::orderBy('country_code', 'ASC')->pluck('country_code')->toArray();
        $country_list = COUNTRIES;

        $countries = array();

            foreach ($country_list as $country) {
                if (in_array($country['code'], $stored_countries))
                {
                    $countries []= $country['name'];
                }
            }

        if($request->search){
            $countries = array_values(preg_grep('~' . $request->search . '~i', $countries));
        }

        return response()->json($countries, 200);
    }

    public function get_restricted_zip_list(Request $request)
    {
        $zipcodes = DeliveryZipCode::orderBy('zipcode', 'ASC')
            ->when($request->search, function ($query) use($request){
                $query->where('zipcode', 'like', "%{$request->search}%");
            })
            ->get();

        return response()->json($zipcodes, 200);
    }

    public function language_change(Request $request){
        $user = $request->user();
        $user->app_language = $request->current_language;
        $user->save();

        return response()->json(['message' => 'Successfully change'], 200);
    }
}
