<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\DirectorRequest;

use App\Models\Director;


class DirectorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'message' => 'Sucesso ao retornar diretores',
            'data' => Director::all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DirectorRequest $request)
    {
        $director = Director::create($request->all());

        return response()->json([
            'message' => 'Sucesso ao criar diretor',
            'data' => $director
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
        $director = Director::find($id)->with('movies')->get();

        return response()->json([
            'message' => 'Sucesso ao retornar diretor',
            'data' => $director
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DirectorRequest $request, $id)
    {
        $director = Director::find($id);

        $director->update($request->all());

        return response()->json([
            'message' => 'Sucesso ao atualizar diretor',
            'data' => $director
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
        $director = Director::find($id);

        if($director->movies->isNotEmpty())
        {
            return response()->json([
                'message' => 'Não foi possivel deletar diretor',
            ], 400);
        }

        $director->delete();

        return response()->json([
            'message' => 'Sucesso ao deletar diretor',
        ], 200);
    }
}
