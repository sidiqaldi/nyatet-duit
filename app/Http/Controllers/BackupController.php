<?php

namespace App\Http\Controllers;

use App\Exports\TransactionExport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

        if ($headings != ['test', 'test']) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
