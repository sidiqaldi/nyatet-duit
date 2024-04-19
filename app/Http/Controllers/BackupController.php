<?php

namespace App\Http\Controllers;

use App\Exports\TransactionExport;
use App\Imports\TransactionImport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class BackupController extends Controller
{
    public function index(): InertiaResponse
    {
        return Inertia::render('Backup/Index');
    }

    public function show(string $period)
    {
        return Excel::download(new TransactionExport($period), "backup-{$period}.xlsx");
    }

    public function update(string $period, Request $request)
    {
        $headings = (new HeadingRowImport)->toArray($request->file);

        $validatedValue = [[["date", "type", "category", "amount",  "description"]]];

        if ($headings != $validatedValue) {
            return redirect()->back()->withErrors(['files', __('Invalid header file')]);
        }

        Excel::import(new TransactionImport($period, Auth::id()), $request->file);

        return redirect()->back()->with('success', 'Import process done.');
    }
}
