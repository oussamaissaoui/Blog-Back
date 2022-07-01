<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Author;
use Auth;


use App\Http\Resources\AuthorRessource;

class ArticleController extends Controller
{
    //

    public function addArticle(Request $request){

        $validator = Validator::make($request->all(), [
            'title' => 'required| min:2 | max:50',
            'body' => 'required',
            'author' => 'required',
            
        ]);

        if($validator->fails()){
            return $validator->errors();     
          }

        else {

            $article=new Article();
            $article->title=$request->title;
            $article->user_id=Auth::user()->id;
            $article->author_id=$request->author;
            $article->body=$request->body;

            $article->save();

            return Response()->json(['success'=>'Article created successfully !',
                                    'article'=>$article
        ]);
            
        }

        
    }


    public function getAllArticles(){

        return Article::where('user_id',Auth::user()->id)->with(['comment','Author'])->orderBy('id','DESC')->paginate(10);

    }


    public function getOneArticle($id){
           
        if(Article::where('id',$id)->with(['comment','Author'])->first()){
          
           $article=Article::where('id',$id)->with(['comment','Author'])->first();
           return $article;
        }else{
            return Response()->json(['error'=>'Article not found!']);
        }

    }



    public function getAuthorList(){

       return AuthorRessource::collection(Article::where('user_id',Auth::user()->id)->with(['Author'])->orderBy('id','DESC')->paginate(10));

    }


    public function addComment(Request $request,$id){

        $validator = Validator::make($request->all(), [
            'comment' => 'required| min:2 | max:50'
            
        ]);

        if($validator->fails()){
            return $validator->errors();     
          }

          else {

            $comment=new Comment();
            $comment->user_id=Auth::user()->id;
            $comment->article_id=$id;
            $comment->comment=$request->comment;

            $comment->save();

            return Response()->json(['success'=>'Comment has been successfully posted !',
                                    'comment'=>$comment]);
          }

    }


    public function deleteComment($id){

        $comment=Comment::where('id',$id)->first();

        if ($comment){
        $comment->delete();
        }
        else {
            return Response()->json(['error'=>'Comment not found!']);
        }

    }
}
