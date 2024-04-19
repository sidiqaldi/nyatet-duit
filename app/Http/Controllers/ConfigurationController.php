<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfigurationUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class ConfigurationController extends Controller
{
    public function update(ConfigurationUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        $request->user()->save();

        return Redirect::route('profile.edit');
    }
}
