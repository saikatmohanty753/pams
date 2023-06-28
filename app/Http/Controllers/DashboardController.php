<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard.index');
    }
    /*********************************************
     * Project Status graph
     * Date - 28-06-2023
     * By Saikat Mohanty
     *********************************************/
    public function totalCount(Request $request)
    {
        return response()->json([view('dashboard.total_count')->render()]);
    }
    public function projectStatus(Request $request)
    {
        return response()->json([view('dashboard.project_status')->render()]);
    }

    public function deptWiseTask(Request $request)
    {
        return response()->json([view('dashboard.dept_task')->render()]);
    }

    public function taskWiseUpdate(Request $request)
    {
        return response()->json([view('dashboard.task_updates')->render()]);
    }
}
