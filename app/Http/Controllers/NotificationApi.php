<?php

namespace App\Http\Controllers;
use App\Models\Topic;
use App\Models\User;
use App\Models\TopicSubscriber;
use App\Models\TopicComment;
use Illuminate\Http\Request;
use Validator;
use Response;
use Illuminate\Support\Facades\Notification;


 /**
 * @OA\Post(
 * path="/publish/{topic}",
 * summary="Publish message to topic",
 * description="Publish message to topic",
 * operationId="authLogin",
 * tags={"auth"},
 * @OA\RequestBody(
 *    required=true,
 *    description="Pass user credentials",
 *    @OA\JsonContent(
 *       required={"email","password"},
 *       @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
 *       @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
 *       @OA\Property(property="persistent", type="boolean", example="true"),
 *    ),
 * ),
 * @OA\Response(
 *    response=422,
 *    description="Wrong credentials response",
 *    @OA\JsonContent(
 *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
 *        )
 *     )
 * )
 */

class NotificationApi extends Controller
{
    public function subscriber(Request $request,$slug_){
       
        $rules =['url'   => 'required|min:6'];
       $validator = Validator::make($request->all(),$rules);
       if($validator->fails())  return Response::json($validator->errors(), 403);
        
        $slug= Topic::where('slug', $slug_)->first();
        if (!$slug)  return Response::json(['error'=> 'Invalid topic slug'], 204);
        $user= User::orderByRaw('RAND()')->first();

        TopicSubscriber::create([
            'url' =>  $request->url,
            'topic_slug' => $slug_,
            'user_id' => $user->id,
        ]);

        return Response::json([
            'url'=> $request->url,
            'topic' => $slug->subject
        ],201);
    }


    public function publisher(Request $request,$slug_){
        $rules =[
            'message' => 'required|min:6'
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()) return Response::json($validator->errors(), 403);


        $slug= Topic::where('slug', $slug_)->first();
        if (!$slug) return Response::json(['error'=> 'Invalid topic slug'], 204);
        $user= User::orderByRaw('RAND()')->first();

        // $resp = TopicComment::create([
        //     'body' =>  $request->message,
        //     'topic_id' => $slug->topic_id,
        //     'user_id' => $user->id
        // ]);

        $subscriber=TopicSubscriber::where('topic_slug', $slug_)
            ->leftJoin('users', 'subscriber_topic.user_id', '=', 'users.id')->orderBy('user_id','desc')->get();


            foreach ($subscriber as $value) {
                $details = [

                    'greeting' => 'Hi '.$value->name,
        
                    'body' => 'You have a new notification "'.$slug->subject.' ,Added By ' .$user->name,
        
                    'thanks' => 'Thank you for using Pangaea notification',
        
                    'actionText' => 'click here',
        
                    'actionURL' => url('/'),
        
                    'order_id' => '$resp->id',
                    'email' => $value->email
        
                ];
                $value->notify(new \App\Notifications\EmailMessage($details),);
            }
            return  Response::json([$slug_,$subscriber], 403);



        // return  Response::json([
        //     'topic' => $slug->subject,
        //     'data'=>$resp
        // ], 201); 

    }
}
