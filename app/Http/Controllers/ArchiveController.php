<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ArchiveController extends Controller
{

    public function showArchiveAccount()
    {
        // Use query builder to paginate before fetching the data
        $archiveUsers = User::where('archive_status', 0)  // Filter by archive_status = 0
            ->paginate(10);  // Paginate the results

        // Pass archiveUsers to the view
        return view('admin.archive.account', compact('archiveUsers'));
    }
}
