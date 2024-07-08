<?php

namespace App\Http\Controllers;

use App\Models\DailyRecord;
use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */



    public function index(Request $request){

        $data = User::all();

        $counts = $data->count();

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
            ->editColumn('name', function($row){
    
                $datas = json_decode($row->name); 

                $html = '';

                foreach($datas as $key => $value){
                    $html .= $value .' ';
                }
                return $html;
            })
            ->editcolumn('gender', function($row){
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
    


        return view('user', compact('counts'));
    }


    public function destroy(User $user){

        //update user gender count
        //get created_at date
        $date = date('Y-m-d', strtotime($user->created_at));

        if ($user->gender === 'male') {
            DailyRecord::where('date', $date)->decrement('male_count');
        } elseif ($user->gender === 'female') {
            DailyRecord::where('date', $date)->decrement('female_count');
        }

        $user->delete();


        return redirect()->route('user.index');
    }
}
