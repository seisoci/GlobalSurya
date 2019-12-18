<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Raport;
use Validator;
use App\Http\Resources\Raport as RaportResource;

class RaportController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $raport = Raport::all();

        return $this->sendResponse(RaportResource::collection($raport), 'Raports retrieved successfully.');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $raport = Raport::create($input);

        return $this->sendResponse(new RaportResource($raport), 'Raport created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $raport = Raport::find($id);

        if (is_null($raport)) {
            return $this->sendError('Raport not found.');
        }

        return $this->sendResponse(new RaportResource($raport), 'Raport retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Raport $raport)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $raport->name = $input['name'];
        $raport->detail = $input['detail'];
        $raport->save();

        return $this->sendResponse(new RaportResource($raport), 'Raport updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Raport $raport)
    {
        $raport->delete();

        return $this->sendResponse([], 'Raport deleted successfully.');
    }
}
