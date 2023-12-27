<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Interaction;
use Illuminate\Http\Request;

class InteractionController extends Controller
{
    
    // Retrieve all Interaction related to user
    function index(Request $req)
    {
        $list = Interaction::where('user_id', $req->user()->id)->get(); 
        return response()->json(['status' => 200, 'message' => 'Interations Fetched Successfuly', 'data' => $list]);
    }  
    
    // Retrieve Single Record by ID
    function show($id)
    {
        $interaction = Interaction::find($id);

        if (!$interaction) {
            return response()->json(['status' => 404, 'message' => 'Interaction not found'], 404);
        } 

        return response()->json(['status' => 200, 'message' => 'Interaction Data Fetched successfully', 'data' => $interaction]); 
    }  
    
    function store(Request $req)
    {
        $req->validate([ 
            'label' => 'required',
            'type' => 'required|in:button,link',
        ]);   
 
        // Storing Interaction Data to DB
        $n = new Interaction();
        $n->user_id = $req->user()->id;
        $n->label = $req->label;
        $n->type = $req->type;
        $n->save(); 

        return response()->json(['status' => 200, 'message' => 'Interation Created Successfuly', 'data' => $n]);
    } 

    function update(Request $req)
    {
        $req->validate([ 
            'edit_id' => 'required',
            'label' => 'required',
            'type' => 'required|in:button,link',
        ]);   

        if(Interaction::where('id', $req->edit_id)->count() == 0 )
        {
            return response()->json(['status' => 403, 'message' => 'Invalide Edit ID Passed', 'data' => null]);
        }
 
        // Storing Interaction Data to DB
        $n = Interaction::where('id', $req->edit_id)->first();
        $n->label = $req->label;
        $n->type = $req->type;
        $n->save(); 
 
        return response()->json(['status' => 200, 'message' => 'Interation Updated Successfuly', 'data' => $n]);
    } 

    function destroy($id)
    {
        $interaction = Interaction::find($id);

        if (!$interaction) {
            return response()->json(['status' => 404, 'message' => 'Interaction not found'], 404);
        }
 
        $interaction->delete();

        return response()->json(['status' => 200, 'message' => 'Interaction deleted successfully', 'data' => null]); 
    } 
}
