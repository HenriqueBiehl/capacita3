<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ActorRequest;
use App\Models\Actor;
use App\Models\Movie;

class ActorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'message' => 'Sucesso ao retornar atores',
            'data' => Actor::all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActorRequest $request)
    {
        if(!$request->movie_id){
            return response()->json([
                'message' => 'Chave estrangeira faltando'
            ], 400);
        }

        foreach($request->movie_id as $movie_id){
            if(!Movie::find($movie_id)){
                return response()->json([
                    'message' => 'Chave estrangeira de filme inválida',
                ], 404); 
            }
        }
        $actor = Actor::create($request->all());
        $actor->movies()->attach($request->movie_id);
        
        return response()->json([
            'message' => 'Sucesso ao criar ator',
            'data' => $actor
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {        
        if(!Actor::find($id)){
            return response()->json([
                'message' => 'Ator não encontrado',
            ], 404); 
        }

        $actor = Actor::find($id)->with('movies')->get();

        return response()->json([
            'message' => 'Sucesso encontrar ator',
            'data' => $actor
        ], 201);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActorRequest $request, $id)
    {
        $actor = Actor::find($id);
        
        if(!$actor){
            return response()->json([
                'message' => 'Ator não encontrado',
            ], 404); 
        }

        if(!$request->movie_id){
            return response()->json([
                'message' => 'Chave estrangeira faltando',
            ], 404); 
        }

        foreach($request->movie_id as $movie_id){
            if(!Movie::find($movie_id)){
                return response()->json([
                    'message' => 'Chave estrangeira de filme inválida',
                ], 404); 
            }
        }

        $actor->update($request->all());
        $actor->movies()->sync($request->movie_id);

        return response()->json([
            'message' => 'Sucesso atualizar ator',
            'data' => $actor
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $actor = Actor::find($id);
        
        if(!$actor){
            return response()->json([
                'message' => 'Ator não encontrado',
            ], 404); 
        }
        
        $actor->movies()->detach();
        $actor->delete();

        return response()->json([
            'message' => 'Sucesso deletar ator',
            'data' => null
        ], 200);
    }
}
