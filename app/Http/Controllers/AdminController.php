<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        // Logic to display the admin dashboard
        return view('admin.dashboard');
    }

    public function manageUsers()
    {
        // Logic to manage users
        return view('admin.users.index');
    }

    public function showProfessors()
    {
        $professors = User::where('is_admin', false)->get(); // professors lang yung ilalabas
        return view('admin.accounts', compact('professors'));
    }

    public function showRooms()
    {
        $rooms = Room::leftJoin('users', 'rooms.professor_name', '=', 'users.name')
            ->select('rooms.*', 'users.rfid_uid as account_no')
            ->get();

        return view('admin.classroom', compact('rooms'));
    }

}
