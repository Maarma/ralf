<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Records;

class RecordsController extends Controller
{
    public function index()
    {
        $records = Records::all();
        return response()->json($records);
    }

    public function store(Request $request)
    {
        $record = new Records;
        $record->name = $request->name;

        $record->save();
        return response()->json([
            "message" => "Record added."
        ], 201);
    }

    public function show($id)
    {
        $record = Records::find($id);
        if(!empty($record))
        {
            return response()->json($record);
        }
        else
        {
            return response()->json([
                "message" => "Record not found."
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        if (Records::where('id', $id)->exists())
        {
            $record = Records::find($id);
            $record->name = is_null($request->name) ? $record->name : $request->name;
            $record->save();
            return response()->json([
                "message" => "Record updated."
            ], 201);
        }
        else
        {
            return response()->json([
                "message" => "Record not found."
            ], 404);
        }
    }
    
    public function destroy($id)
    {
        if(Records::where('id', $id)-exists())
        {
            $record = Records::find($id);
            $record->delete();

            return response()->json([
                "message" => "Record deleted."
            ], 202);
        }
        else
        {
            return response()->json([
                "message" => "Record not found."
            ], 404);
        }
    }
}
