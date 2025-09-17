<?php

namespace App\Http\Controllers\Language_Controller;

use App\Http\Controllers\Controller;
use App\Models\LanguageModule\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LanguageController extends Controller
{
    // Get all Languages
    public static function getAllLanguages(Request $request)
    {
        $data = Language::getAllLanguages();
        return view('language.admin.index', compact('data'));
    }

    // Get Languages By ID
    public static function getLanguageByID(Request $request)
    {
        $validate = Validator::make($request->all(), [
            Language::language_id => 'required|numeric'
        ]);
        if ($validate->fails()) return json_encode([STATUS => VALIDATION_ERROR, DATA => $validate->errors()->all()]);

        $data = Language::getLanguageByID($request);

        return [STATUS => OK, DATA => $data];
    }

    // Add Languages
    public static function addLanguage(Request $request)
    {
        $validate = Validator::make($request->all(), [
            Language::label_as => 'required|alpha|max:255',
            Language::name => 'required|max:255',
            Language::language_code => 'required|alpha_dash|max:255',
            Language::locale => 'required|alpha|max:255'
        ]);
        if ($validate->fails()) return redirect()->back()->withErrors($validate->errors())->withInput();

        $recordType = $request->filled(Language::language_id) ? UPDATE_RECORD : CREATE_RECORD;

        Language::addOrUpdate($request, $recordType);

        return redirect()->back()->with('message', 'Success');
    }

    // Delete Languages
    public static function deleteLanguage(Request $request)
    {
        $validate = Validator::make($request->all(), [
            Language::language_id => 'required'
        ]);
        if ($validate->fails()) return redirect()->back()->withErrors($validate->errors())->withInput();

        Language::deleteLanguage($request);

        return [STATUS => OK, DATA => true];
    }
}
