<?php


namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiBaseController as ApiBaseController;
use App\Clip;
use Validator;


class ClipController extends ApiBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clips = Clip::all();
        return $this->sendResponse($clips->toArray(), 'Clips retrieved successfully.');
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
            'filename' => 'required',
            //'detail' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $clip = Clip::create($input);
        return $this->sendResponse($clip->toArray(), 'Clip created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $clip = Clip::find($id);
        if (is_null($clip)) {
            return $this->sendError('Clip not found.');
        }
        return $this->sendResponse($clip->toArray(), 'Clip retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Clip $clip)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'filename' => 'required',
            //'detail' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $clip->caption = $input['caption'];
        $clip->filename = $input['filename'];
        $clip->save();
        return $this->sendResponse($clip->toArray(), 'Clip updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Clip $clip)
    {
        $clip->delete();
        return $this->sendResponse($clip->toArray(), 'Clip deleted successfully.');
    }
}
