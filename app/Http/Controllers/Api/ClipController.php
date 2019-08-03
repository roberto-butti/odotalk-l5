<?php


namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiBaseController as ApiBaseController;
use App\Clip;
use Validator;


class ClipController extends ApiBaseController
{
    /**
     * @api {get} /user/:id Request User information
     * @apiName GetUser
     * @apiGroup User
     *
     * @apiParam {Number} id Users unique ID.
     *
     * @apiSuccess {String} firstname Firstname of the User.
     * @apiSuccess {String} lastname  Lastname of the User.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "firstname": "John",
     *       "lastname": "Doe"
     *     }
     *
     * @apiError UserNotFound The id of the User was not found.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": "UserNotFound"
     *     }
     */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        if ($user) {
            $clips = Clip::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->simplePaginate(5);
            //->get();
            return $this->sendResponse($clips->toArray(), 'Clips retrieved successfully.');
        } else {
            return $this->sendUnauth();
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //die($request->user());
        $input = $request->all();

        //die();
        $input["user_id"] = $request->user()->id;
        //dd($input);
        $validator = Validator::make($input, [
            'filename' => 'required',
            //'user_id' => $request->user()->id
            //'detail' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $file_name = "prova.mp3";
        $path = $request->file("audio")->move(public_path("/"), $file_name);
        $input["filename"] = url("/" . $file_name);

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
            return $this->sendNotFound("Clip not found");
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
            'caption' => 'required'

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
