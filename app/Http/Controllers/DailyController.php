<?php

namespace App\Http\Controllers;

use App\Models\DailyRecord;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DailyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = DailyRecord::all();

        if($request->ajax()){
    
            return DataTables::of($data)->addIndexColumn()
            ->addColumn('action', function($row){
    
                $btn = '
    
                <form action="'.route('user.destroy', [$row->id]).'" method="post">
                '.csrf_field().'
                '.method_field("DELETE").'
                <button type="submit" class="btn btn-sm btn-danger" title="Delete">Delete<i class="fas fa-times"></i></button></form>
                        ';
    
                return $btn;
            })
            ->editColumn('date', function($row){
    
                return date('d M Y', strtotime($row->date));
            })
            ->editcolumn('male_count', function($row){
                $datas = $row->gender;

                return $datas;
            })
            ->editcolumn('age', function($row){
                $datas = $row->age;

                return $datas;
            })
            ->editcolumn('created_at', function($row){
                return date('d M Y h:i:s A', strtotime($row->created_at));
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true)
            ;
        }

        return view('daily-record');
    }

}
