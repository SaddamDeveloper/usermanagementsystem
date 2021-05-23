<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index');
    }

    public function userDataAjax(Request $request)
    {
        $users = User::latest();
        return DataTables::collection($users->get())
            ->addIndexColumn()
            ->addColumn('avatar', function ($row) {
                return '<img src="' . asset('/images/' . $row->avatar) . '" height="50" alt="avatar">';
            })
            ->addColumn('action', function ($row) {
                $btn = '<button href="" name="delete" id="' . $row->id . '" class="delete btn btn-danger">Remove</button>';
                return $btn;
            })
            ->rawColumns(['action', 'avatar'])
            ->make(true);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        // Avatar
        $image_name = $this->avatar($request);
        // Experience
        $experience = $this->experience($request);
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->experience = $experience;
        $user->avatar = $image_name;

        if ($user->save()) {
            $response = [
                'status' => true,
                'message' => 'Data added successfully'
            ];
            return response()->json($response);
        } else {
            $response = [
                'status' => false,
                'message' => 'Something went wrong!'
            ];
            return response()->json($response);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        if ($user->delete()) {
            if (File::exists(public_path('images/' . $user->avatar))) {
                File::delete(public_path('images/' . $user->avatar));
            }
            $response = [
                'status' => true,
                'message' => 'Deleted Successfully'
            ];
            return response()->json($response);
        } else {
            $response = [
                'status' => false,
                'message' => 'Something went wrong'
            ];
            return response()->json($response);
        }
    }

    private function avatar($request)
    {
        $path = base_path() . '/public/images/';
        File::exists($path) or File::makeDirectory($path, 0777, true, true);
        $image = $request->file('image');
        $image_name = time() . date('Y-M-d') . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $image_name);
        return $image_name;
    }

    public function experience($request)
    {
        $dol = $request->input('dol');
        $doj = $request->input('doj');
        $still_working = $request->input('still_working');
        $doj = Carbon::parse($doj);
        if ($dol) {
            $dol = Carbon::parse($dol);
            $interval = $doj->diffForHumans($dol, true);
            return $interval;
        } else if ($still_working) {
            $now = Carbon::now();
            $interval = $doj->diffForHumans($now, true);
            return $interval;
        }
    }
}
