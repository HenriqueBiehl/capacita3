<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\MovieRequest;

use App\Models\Movie;
use App\Models\Director;

use Storage;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'message' => 'Sucesso ao retornar filmes',
            'data' => Movie::all()
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MovieRequest $request)
    {

        if(!Director::find($request->director_id)){
            return response()->json([
                'message' => 'Chave Estrangeira Inválida'
            ], 400);
        }

        if(!$request->movie_poster){
            return response()->json([
                'message' => 'Campo movie poster é obrigatório'
            ], 400);
        }

        $file_path = $request->file('movie_poster')->store('public/posters');

        $movie = Movie::create([
            'title' => $request->title,
            'movie_poster' => $file_path,
            'year' => $request->year,
            'producer' => $request->producer,
            'run_time' => $request->run_time,
            'director_id' => $request->director_id
        ]);

        return response()->json([
            'message' => 'Sucesso ao criar filme',
            'data' => $movie
        ], 200);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $movie = Movie::find($id);

        return response()->json([
            'message' => 'Sucesso ao retornar filme',
            'data' => $movie
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MovieRequest $request, $id)
    {
        if(!Director::find($request->director_id)){
            return response()->json([
                'message' => 'Chave estrangeira inválida'
            ], 400);
        }

        $movie = Movie::find($id)->first();

        $image_path = NULL; 

        if($request->file('movie_poster')){
            if(Storage::exists($movie->movie_poster)){
                Storage::delete($movie->movie_poster);
            }
            $image_path = $request->file('movie_poster')->store('public/posters');
        }
        
        $movie->update([
            'title' => $request->title,
            'movie_poster' => $image_path ? $image_path : $movie->movie_poster,
            'year' => $request->year,
            'producer' => $request->producer,
            'run_time' => $request->run_time,
            'director_id' => $request->director_id
        ]);

        return response()->json([
            'message' => 'Sucesso ao atualizar filme',
            'data' => $movie
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $movie = Movie::find($id);

        if(!$movie){
            return response()->json([
                'message' => 'filme não encontrado'
            ], 404);
        }

        if(Storage::exists($movie->movie_poster)){
            Storage::delete($movie->movie_poster);
        }

        $movie->actors()->detach();
        $movie->delete();

        return response()->json([
            'message' => 'Sucesso ao deletar filme'
        ], 200);
    }
}
