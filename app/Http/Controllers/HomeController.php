<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clubslot;

class HomeController extends Controller
{
    public function home(Request $request){
        return view('welcome');
    }
    public function AssignSlot(Request $request){
        $data = $request->all();
        // \Log::info($data);
        return Clubslot::create($data);
    }
    public function booked(Request $request){
        $data = $request->all();
        // $book = $request->book;
        return Clubslot::where('id',$data['id'])->update($data);
    }
    public function showSlot(Request $request){
        $day = $request->day;
        $data = $request->all();
        // \Log::info($data);
        return Clubslot::where('dayName',$day)->get();
    }
    public function allSlot(Request $request){
        $data = $request->all();
        return Clubslot::all();
    }
}
