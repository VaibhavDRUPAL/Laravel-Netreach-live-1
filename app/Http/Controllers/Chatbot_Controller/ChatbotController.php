<?php

namespace App\Http\Controllers\Chatbot_Controller;

use App\Common\IPStack;
use App\Http\Controllers\Controller;
use App\Models\AnonymousModule\Visitors;
use App\Models\ChatbotModule\{Content, Greetings, LanguageCounter, Questionnaire, UserDetails};
use App\Models\LanguageModule\Language;
use App\Models\MediaModule\MediaType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Config, Cookie, Validator};
use Illuminate\Validation\Rule;

class ChatbotController extends Controller
{
    // Validate Questionnaire
    protected static function validateQuestionnaire($request, $isAnswer = false)
    {
        $validate = Validator::make($request->all(), [
            Greetings::locale => 'required',
            Questionnaire::question_id => Rule::requiredIf($isAnswer && !$request->filled(OFFSET))
        ]);

        return $validate->fails() ? $validate : true;
    }
    // Validate User Details
    protected static function validateUserDetails($request)
    {
        $validate = Validator::make($request->all(), [
            UserDetails::full_name => 'required|max:255',
            UserDetails::phone_number => 'required|digits_between:10,10|regex:' . MOB_REGEX
        ]);

        return $validate->fails() ? $validate : true;
    }
    
    // Get Languges
    public static function getLanguges(Request $request)
    {
        $data = Language::getAllLanguages();

        if (Cookie::has(Questionnaire::selected_questions)) Cookie::queue(Cookie::forget(Questionnaire::selected_questions));
        
        if (Cookie::has(Greetings::locale)) Cookie::queue(Cookie::forget(Greetings::locale));

        return view('chatbot.index', compact('data'));
    }
    // Get Greetings
    public static function getGreetings(Request $request)
    {
        $validate = self::validateQuestionnaire($request);
        if (!is_bool($validate)) return json_encode([STATUS => VALIDATION_ERROR, DATA => $validate->errors()->all()]);

        LanguageCounter::counterIncrement($request);

        app()->setLocale($request->input(Greetings::locale, Config::get('app.fallback_locale')));
        Cookie::queue(Cookie::make(Greetings::locale, $request->input(Greetings::locale), 15));

        if (!Visitors::checkVisitor($request)) {
            $ipDetails = IPStack::getIPDetails($request->ip());

            $request->merge([
                Visitors::latitude => !empty($ipDetails[IPStack::latitude]) ? $ipDetails[IPStack::latitude] : null,
                Visitors::longitude => !empty($ipDetails[IPStack::longitude]) ? $ipDetails[IPStack::longitude] : null,
                Visitors::country => !empty($ipDetails[IPStack::country_name]) ? $ipDetails[IPStack::country_name] : null,
                Visitors::state => !empty($ipDetails[IPStack::region_name]) ? $ipDetails[IPStack::region_name] : null,
                Visitors::city => !empty($ipDetails[IPStack::city]) ? $ipDetails[IPStack::city] : null,
                Visitors::zip => !empty($ipDetails[IPStack::zip]) ? $ipDetails[IPStack::zip] : null,
                Visitors::isp => !empty($ipDetails[IPStack::connection][IPStack::isp]) ? $ipDetails[IPStack::connection][IPStack::isp] : null
            ]);

            Visitors::addOrUpdate($request);
        }

        $locale = $request->input(Greetings::locale);
        $greetings = collect()->make();
        $questionnaire = collect()->make();

        $data = Greetings::getAllGreetings();
        $data->pluck(Greetings::greetings)->filter(function ($val) use ($locale, $greetings) {
            $locale = collect($val)->where(Greetings::locale, $locale)->isNotEmpty() ? $locale : 'en';
            collect($val)->where(Greetings::locale, $locale)->each(function ($val) use ($greetings) {
                $greetings->push($val);
            });
        });
        $html = view('chatbot.ajax.greetings', compact('greetings'))->render();

        $data = Questionnaire::getAllQuestionnaire($request);
        $offset = $data->last()[Questionnaire::question_id];
        $data->filter(function ($filter) use ($locale, $questionnaire) {
            $locale = collect($filter[Questionnaire::question])->where(Questionnaire::locale, $locale)->isNotEmpty() ? $locale : 'en';
            collect($filter[Questionnaire::question])->where(Questionnaire::locale, $locale)->each(function ($val) use ($questionnaire, $filter) {
                $questionnaire->put($filter[Questionnaire::question_id], $val);
            });
        });

        $request->merge([
            Content::slug => [LOAD_MORE, BOOK_AN_APPOINTMENT]
        ]);
        $contentData = Content::getAllContent($request);

        $html .= view('chatbot.ajax.questionnaire', compact('questionnaire', 'offset', 'locale', 'contentData'))->render();

        return json_encode([STATUS => OK, DATA => $html]);
    }
    // Get Answer
    public static function getAnswer(Request $request)
    {
        $validate = self::validateQuestionnaire($request, true);
        if (!is_bool($validate)) return json_encode([STATUS => VALIDATION_ERROR, DATA => $validate->errors()->all()]);

        Questionnaire::counterIncrement($request);

        app()->setLocale($request->input(Greetings::locale, Config::get('app.fallback_locale')));

        $locale = Cookie::has(Greetings::locale) ? Cookie::get(Greetings::locale) : Config::get('app.fallback_locale');
        $answers = collect()->make();
        $questionID = $request->input(Questionnaire::question_id);

        $data = Questionnaire::getQuestionnaireByID($request);
        $locale = collect($data[Questionnaire::answer_sheet])->where(Questionnaire::locale, $locale)->isNotEmpty() ? $locale : 'en';
        $data = collect($data[Questionnaire::answer_sheet])->where(Questionnaire::locale, $locale)->first();

        $request->merge([
            Content::slug => [ASK_ANOTHER_QUESTION, ASK_ANOTHER_QUESTION_YES, ASK_ANOTHER_QUESTION_NO]
        ]);
        $contentData = Content::getAllContent($request);

        $html = view('chatbot.ajax.answers', compact('data', 'questionID', 'locale' , 'contentData'))->render();

        $existingQuestions = Cookie::has(Questionnaire::selected_questions) ? collect(json_decode(Cookie::get(Questionnaire::selected_questions))) : collect()->make();

        $existingQuestions->push($request->input(Questionnaire::question_id));

        Cookie::queue(Cookie::make(Questionnaire::selected_questions, $existingQuestions->toJson(), 15));

        return json_encode([STATUS => OK, DATA => $html]);
    }
    // Know More
    public static function showMore(Request $request)
    {
        $validate = self::validateQuestionnaire($request, true);
        if (!is_bool($validate)) return json_encode([STATUS => VALIDATION_ERROR, DATA => $validate->errors()->all()]);

        app()->setLocale($request->input(Greetings::locale, Config::get('app.fallback_locale')));
        
        $locale = Cookie::has(Greetings::locale) ? Cookie::get(Greetings::locale) : Config::get('app.fallback_locale');
        $questionnaire = collect()->make();

        $request->merge([
            Questionnaire::selected_questions => json_decode(Cookie::get(Questionnaire::selected_questions))
        ]);

        $data = Questionnaire::getAllQuestionnaire($request);
        if ($data->isEmpty()) return json_encode([STATUS => OK, DATA => null]);

        $offset = $data->last()[Questionnaire::question_id];
        $data->each(function ($val) use ($questionnaire, $locale) {
            $ID = $val[Questionnaire::question_id];
            $locale = collect($val[Questionnaire::question])->where(Questionnaire::locale, $locale)->isNotEmpty() ? $locale : 'en';
            $questionnaire->put($ID, collect($val[Questionnaire::question])->where(Questionnaire::locale, $locale)->first());
        });

        $request->merge([
            Content::slug => [LOAD_MORE, BOOK_AN_APPOINTMENT]
        ]);
        $contentData = Content::getAllContent($request);

        $html = view('chatbot.ajax.questionnaire', compact('questionnaire', 'offset', 'locale', 'contentData'))->render();

        return json_encode([STATUS => OK, DATA => $html]);
    }
    // Thank You
    public static function thankYou(Request $request)
    {
        $html = view('chatbot.ajax.thank_you')->render();

        return json_encode([STATUS => OK, DATA => $html]);
    }
    // User Details
    public static function userDetails(Request $request)
    {
        $validate = self::validateUserDetails($request);
        if (!is_bool($validate)) return [STATUS => VALIDATION_ERROR, DATA => $validate->errors()->all()];

        $data = UserDetails::checkUser($request);

        if (!$data) {
            $ipDetails = Visitors::getVisitor($request);

            $request->merge([
                UserDetails::latitude => $ipDetails[Visitors::latitude],
                UserDetails::longitude => $ipDetails[Visitors::longitude],
                UserDetails::country => $ipDetails[Visitors::country],
                UserDetails::state => $ipDetails[Visitors::state],
                UserDetails::city => $ipDetails[Visitors::city],
                UserDetails::zip => $ipDetails[Visitors::zip],
                UserDetails::isp => $ipDetails[Visitors::isp],
            ]);

            $data = UserDetails::addOrUpdate($request);
            $data = $data ? true : null;

            Visitors::deleteVisitor($ipDetails[Visitors::visitor_id]);
        }

        return [STATUS => OK, DATA => $data];
    }
    // Reset Chatbot
    public static function resetConfirm(Request $request)
    {
        $locale = Cookie::has(Greetings::locale) ? Cookie::get(Greetings::locale) : Config::get('app.fallback_locale');

        $request->merge([
            Content::slug => [CHAT_AGAIN, CHAT_AGAIN_CONFIRM, CHAT_AGAIN_CANCEL]
        ]);

        $data = Content::getAllContent($request)?->toArray();

        $html = view('chatbot.ajax.reset', compact('data' , 'locale'))->render();

        return [STATUS => OK, DATA => $html];
    }
    // Reset Chatbot
    public static function resetChatbot(Request $request)
    {
        if (Cookie::has(Questionnaire::selected_questions)) Cookie::queue(Cookie::forget(Questionnaire::selected_questions));

        if (Cookie::has(Greetings::locale)) Cookie::queue(Cookie::forget(Greetings::locale));

        $data = Language::getAllLanguages();
        $html = view('chatbot.ajax.language', compact('data'))->render();

        return [STATUS => OK, DATA => $html];
    }
    /**
     * Web Routes
     */
    /**
     * Chatbot Greetings
     */
    // Get All Greetings
    public static function getAllGreetings(Request $request)
    {
        $validate = Validator::make($request->all(), [
            COUNT => Rule::when($request->ajax(), ['required', 'numeric'])
        ]);
        if ($validate->fails()) return json_encode([STATUS => VALIDATION_ERROR, DATA => $validate->errors()->all()]);
        
        if ($request->filled(MediaType::media_type)) {
            $count = $request->input('count');
            $mediaType = $request->input(MediaType::media_type);
            $html = view('chatbot.admin.ajax.media_type', compact('mediaType', 'count'))->render();

            return [STATUS => OK, DATA => $html];
        }
        
        $request->merge([
            MediaType::scope => 'chatbot'
        ]);

        $isAddOn = $request->filled('add_on');

        if (!$isAddOn) $data = $request->filled(Greetings::greeting_id) ? Greetings::getGreetingByID($request) : Greetings::getAllGreetings();

        $language = Language::getAllLanguages();
        $mediaType = MediaType::getAllMediaTypes($request);

        if (!$request->ajax()) return view('chatbot.admin.index', compact('data', 'language', 'mediaType'));

        if (isset($data)) $existing = $data;

        $count = $request->input('count');
        $isAjax = true;

        $html = $isAddOn ? view('chatbot.admin.ajax.greetings', compact('language', 'mediaType', 'isAjax', 'count'))->render() : view('chatbot.admin.ajax.greetings', compact('existing', 'language', 'mediaType', 'isAjax'))->render();

        return [STATUS => OK, DATA => $html];
    }
    // Add Greetings
    public static function addGreetings(Request $request)
    {
        $validate = Validator::make($request->all(), [
            MediaType::media_type => Rule::when($request->filled(Greetings::greeting_id), ['required', 'array']),
            Language::locale => [
                Rule::exists(Language::class, Language::locale),
                Rule::when($request->filled(Greetings::greeting_id), ['required', 'distinct'])
            ],
            Greetings::greeting_title => Rule::when(!$request->filled(Greetings::greeting_id), 'required')
        ]);
        if ($validate->fails()) return $request->ajax() ? json_encode([STATUS => VALIDATION_ERROR, DATA => $validate->errors()->all()]) : redirect()->back()->withErrors($validate->errors());
        
        if ($request->filled(Greetings::greeting_id)) {
            $data = collect()->make();

            foreach ($request->input(MediaType::media_type) as $key => $value) {
                if ($value == IMAGE || $value == AUDIO) {
                    if ($request->hasFile(Greetings::greetings . UNDERSCORE . $value . UNDERSCORE . $key)) {
                        $input = $request->file(Greetings::greetings . UNDERSCORE . $value . UNDERSCORE . $key);
                        $destinationPath = $value == IMAGE ? GREETINGS_IMAGES_PATH : GREETINGS_AUDIO_PATH;
                        $destinationPath .= getFileName() . DOT . $input->getClientOriginalExtension();
                        $input = mediaOperations($destinationPath, $input, FL_CREATE, MDT_STORAGE, STD_PUBLIC);
                    } else if ($request->filled(Greetings::greetings . UNDERSCORE . $value . UNDERSCORE . $key . UNDERSCORE . 'old')) $input = $request->input(Greetings::greetings . UNDERSCORE . $value . UNDERSCORE . $key . UNDERSCORE . 'old');
                } else $input = $request->input(Greetings::greetings . UNDERSCORE . $value . UNDERSCORE . $key);

                $data->push([
                    Language::locale => $request->input(Language::locale)[$key],
                    MediaType::media_type => $value,
                    Greetings::body => $input
                ]);
            }
            $request->merge([Greetings::greetings => $data->all()]);

            Greetings::updateGreetings($request);
        } else Greetings::addGreetings($request);

        return redirect()->back();
    }
    // Delete Greetings
    public static function deleteGreetings(Request $request)
    {
        $validate = Validator::make($request->all(), [
            Greetings::greeting_id => 'required'
        ]);
        if ($validate->fails()) return [STATUS => VALIDATION_ERROR, DATA => $validate->errors()->all()];

        Greetings::deleteGreeting($request);

        return [STATUS => OK, DATA => true];
    }
    /**
     * Chatbot Questionnaire
     */
    // Add Questionnaire
    public static function addQuestionnaire(Request $request)
    {
        $validate = Validator::make($request->all(), [
            Language::locale => 'required|array',
            Language::locale . DOT . STAR => [
                'distinct',
                Rule::exists(Language::class, Language::locale),
            ],
            Questionnaire::question => 'required|array',
        ]);
        if ($validate->fails()) return $request->ajax() ? json_encode([STATUS => VALIDATION_ERROR, DATA => $validate->errors()->all()]) : redirect()->back()->withErrors($validate->errors());

        $data = collect()->make();

        foreach ($request->input(Language::locale) as $key => $locale) {
            $data->push([
                Language::locale => $locale,
                Questionnaire::body => $request->input(Questionnaire::question)[$key]
            ]);
        }

        if ($request->filled(Questionnaire::question_id)) {
            $existing = Questionnaire::getQuestionnaireByID($request);
            $request->merge([
                Questionnaire::question => collect($existing[Questionnaire::question])->merge($data)->all()
            ]);
            Questionnaire::updateQuestionnaire($request);
        } else {
            $request->merge([
                Questionnaire::question => $data->all()
            ]);
            Questionnaire::addQuestionnaire($request);
        }

        return redirect()->back();
    }
    // Update Questionnaire
    public static function updateQuestionnaire(Request $request)
    {
        $validate = Validator::make($request->all(), [
            Questionnaire::question_id => 'required',
            Language::locale => 'required',
            Questionnaire::question => 'required',
        ]);
        if ($validate->fails()) return $request->ajax() ? json_encode([STATUS => VALIDATION_ERROR, DATA => $validate->errors()->all()]) : redirect()->back()->withErrors($validate->errors());

        $data = Questionnaire::getQuestionnaireByID($request);
        if (empty($data)) return redirect()->back();

        $existing = $data[Questionnaire::question];

        foreach ($existing as $key => $value) {
            if ($value[Questionnaire::locale] == $request->input(Questionnaire::locale))
                $existing[$key][Questionnaire::body] = $request->input(Questionnaire::question);
        }

        $request->merge([
            Questionnaire::question => $existing
        ]);

        Questionnaire::updateQuestionnaire($request);

        return redirect()->back();
    }
    // Delete Answer
    public static function deleteQuestion(Request $request)
    {
        $validate = Validator::make($request->all(), [
            Questionnaire::question_id => 'required',
            Questionnaire::locale => 'required'
        ]);
        if ($validate->fails()) return json_encode([STATUS => VALIDATION_ERROR, DATA => $validate->errors()->all()]);

        $existing = Questionnaire::getQuestionnaireByID($request);

        $question = $existing[Questionnaire::question];
        $answerSheet = $existing[Questionnaire::answer_sheet];

        foreach ($question as $key => $value) if ($value[Questionnaire::locale] == $request->input(Questionnaire::locale)) unset($question[$key]);
        foreach ($answerSheet as $key => $value) if ($value[Questionnaire::locale] == $request->input(Questionnaire::locale)) unset($answerSheet[$key]);

        $request->merge([
            Questionnaire::question => $question,
            Questionnaire::answer_sheet => $answerSheet
        ]);

        Questionnaire::updateQuestionnaire($request);
        Questionnaire::updateAnswerSheet($request);

        return [STATUS => OK, DATA => true];
    }
    // Destroy Answer
    public static function destroyQuestion(Request $request)
    {
        $validate = Validator::make($request->all(), [
            Questionnaire::question_id => 'required'
        ]);
        if ($validate->fails()) return json_encode([STATUS => VALIDATION_ERROR, DATA => $validate->errors()->all()]);

        Questionnaire::destroyQuestionnaire($request);

        return [STATUS => OK, DATA => true];
    }
    // Update Answer Sheet
    public static function updateAnswerSheet(Request $request)
    {
        $validate = Validator::make($request->all(), [
            MediaType::media_type => 'required|array',
            Questionnaire::locale => 'required'
        ]);
        if ($validate->fails()) return $request->ajax() ? json_encode([STATUS => VALIDATION_ERROR, DATA => $validate->errors()->all()]) : redirect()->back()->withErrors($validate->errors());

        $data = collect()->make();

        foreach ($request->input(MediaType::media_type) as $key => $value) {
            if ($value == IMAGE || $value == AUDIO) {
                if ($request->hasFile(Questionnaire::answer . UNDERSCORE . $value . UNDERSCORE . $key)) {
                    $input = $request->file(Questionnaire::answer . UNDERSCORE . $value . UNDERSCORE . $key);
                    $destinationPath = $value == IMAGE ? ANSWER_IMAGES_PATH : ANSWER_AUDIO_PATH;
                    $destinationPath .= getFileName() . DOT . $input->getClientOriginalExtension();
                    $input = mediaOperations($destinationPath, $input, FL_CREATE, MDT_STORAGE, STD_PUBLIC);
                    $oldPath = $request->input(Questionnaire::answer . UNDERSCORE . $value . UNDERSCORE . $key . UNDERSCORE . 'old');
                    if (!empty($oldPath)) mediaOperations($oldPath, null, FL_DELETE);
                } else if ($request->filled(Questionnaire::answer . UNDERSCORE . $value . UNDERSCORE . $key . UNDERSCORE . 'old')) $input = $request->input(Questionnaire::answer . UNDERSCORE . $value . UNDERSCORE . $key . UNDERSCORE . 'old');
            } else $input = $request->input(Questionnaire::answer . UNDERSCORE . $value . UNDERSCORE . $key);

            $data->push(
                [
                    Questionnaire::title => $value == LINK ? $request->input(Questionnaire::answer . UNDERSCORE . $value . UNDERSCORE . $key . UNDERSCORE . Questionnaire::title) : null,
                    MediaType::media_type => $value,
                    Questionnaire::content => $input
                ]
            );
        }

        $existing = Questionnaire::getQuestionnaireByID($request);
        $answerSheet = $existing[Questionnaire::answer_sheet];

        if (!empty($answerSheet)) {
            foreach ($answerSheet as $key => $value) {
                if ($value[Questionnaire::locale] == $request->input(Questionnaire::locale)) {
                    $answerSheet[$key][Questionnaire::body] = $data->all();
                    $data = collect()->make();
                }
            }
        }

        if ($data->isNotEmpty() || empty($answerSheet)) $answerSheet[] = [Questionnaire::locale => $request->input(Questionnaire::locale), Questionnaire::body => $data->all()];

        $request->merge([
            Questionnaire::answer_sheet => $answerSheet
        ]);

        Questionnaire::updateAnswerSheet($request);

        return redirect()->back();
    }
    // Get All Questionnaire
    public static function getAllQuestionnaire(Request $request)
    {
        $validate = Validator::make($request->all(), [
            COUNT => Rule::when($request->ajax(), ['required', 'numeric']),
            Questionnaire::locale => Rule::requiredIf($request->ajax())
        ]);
        if ($validate->fails()) return json_encode([STATUS => VALIDATION_ERROR, DATA => $validate->errors()->all()]);

        $request->merge([
            MediaType::scope => 'chatbot'
        ]);
        
        $language = Language::getAllLanguages();
        $questionnaire = Questionnaire::getAllQuestionnaire($request);
        $mediaType = MediaType::getAllMediaTypes($request);

        if (!$request->ajax()) return view('chatbot.admin.questionnaire', compact('language', 'questionnaire', 'mediaType'));

        $data = Questionnaire::getQuestionnaireByID($request);
        if (isset($data)) $existing = $data;

        $count = $request->input('count');
        $locale = $request->input(Questionnaire::locale);
        $isAjax = true;

        $html = view('chatbot.admin.ajax.answer', compact('existing', 'mediaType', 'language', 'isAjax', 'count', 'locale'))->render();

        return [STATUS => OK, DATA => $html];
    }
    // Add More Answers
    public static function mediaType(Request $request)
    {
        $validate = Validator::make($request->all(), [
            INDEX => 'required',
            FIELD_TYPE => 'required',
            MediaType::media_type => 'required'
        ]);
        if ($validate->fails()) return json_encode([STATUS => VALIDATION_ERROR, DATA => $validate->errors()->all()]);

        $index = $request->input('index');
        $fieldType = $request->input('field_type');
        $mediaType = $request->input(MediaType::media_type);

        $html = view('chatbot.admin.ajax.media_type', compact('mediaType', 'fieldType', 'index'))->render();

        return [STATUS => OK, DATA => $html];
    }
    // Add More Questions
    public static function addMoreQuestions(Request $request)
    {
        $validate = Validator::make($request->all(), [
            Questionnaire::question_id => 'present'
        ]);
        if ($validate->fails()) return json_encode([STATUS => VALIDATION_ERROR, DATA => $validate->errors()->all()]);

        $language = Language::getAllLanguages();
        $existing = Questionnaire::getQuestionnaireByID($request);
        $existingLocale = isset($existing[Questionnaire::question]) ? collect($existing[Questionnaire::question])->pluck(Questionnaire::locale) : null;

        if ($language->pluck(Language::locale)->diff($existingLocale)->isEmpty()) return [STATUS => VALIDATION_ERROR, DATA => ['No any language available to add more questions!']];

        $html = view('chatbot.admin.ajax.question', compact('language', 'existingLocale'))->render();

        return [STATUS => OK, DATA => $html];
    }
    // Add More Answers
    public static function addMoreAnswers(Request $request)
    {
        $validate = Validator::make($request->all(), [
            COUNT => 'required'
        ]);
        if ($validate->fails()) return json_encode([STATUS => VALIDATION_ERROR, DATA => $validate->errors()->all()]);

        $request->merge([
            MediaType::scope => 'chatbot'
        ]);

        $count = $request->input('count');
        $mediaType = MediaType::getAllMediaTypes($request);
        $isAjax = true;

        $html = view('chatbot.admin.ajax.answer', compact('mediaType', 'isAjax', 'count'))->render();

        return [STATUS => OK, DATA => $html];
    }
    /**
     * Language Counter
     */
    // Get Language Counter
    public static function getLanguageCounter(Request $request)
    {
        $data = LanguageCounter::getAllCounter($request);
        return view('chatbot.language.counter', compact('data'));
    }
    /**
     * Users
     */
    // Get All Chatbot Users
    public static function getAllChatbotUsers(Request $request)
    {
        if (!$request->ajax()) return view('chatbot.user.index');

        $data = UserDetails::getAllUsers($request);

        $json_data = array(
            "draw"            => intval($request->draw),
            "recordsTotal"    => intval($data->count()),
            "recordsFiltered" => intval($data->count()),
            "data"            => $data->items()
        );

        echo json_encode($json_data);
        exit;
    }
    /**
     * Visitors
     */
    // Get All Visitors
    public static function getAllVisitors(Request $request)
    {
        if (!$request->ajax()) return view('chatbot.visitor.anonymous');

        $data = Visitors::getAllVisitors($request);

        $json_data = array(
            "draw"            => intval($request->draw),
            "recordsTotal"    => intval($data->count()),
            "recordsFiltered" => intval($data->count()),
            "data"            => $data->items()
        );

        echo json_encode($json_data);
        exit;
    }
    /**
     * Content
     */
    // Get All Content
    public static function getAllContent(Request $request)
    {
        $data = Content::getAllContent();
        return view('chatbot.admin.content', compact('data'));
    }
    // Update Content
    public static function updateContent(Request $request)
    {
        $validate = Validator::make($request->all(), [
            Language::locale => 'required|array|min:1',
            Language::locale . DOT . STAR => 'distinct',
            Content::content => 'required|array|min:1'
        ]);
        if ($validate->fails()) return redirect()->back()->withErrors($validate->errors());

        $content = collect()->make();
        foreach ($request->input(Language::locale) as $key => $value)
        $content->put($value, $request->input(Content::content)[$key]);

        $request->merge([
            Content::content => $content->all()
        ]);

        Content::updateContent($request);
        return redirect()->back()->with('message', 'Success');
    }
    // Get Content By ID
    public static function getContentByID(Request $request)
    {
        $language = Language::getAllLanguages();
        $comapct = ['language'];

        if ($request->filled(Content::content_id)) {
            $data = Content::getContentByID($request);
            $comapct[] = 'data';
        }

        $html = view('chatbot.admin.ajax.content', compact($comapct))->render();

        return [STATUS => OK, DATA => $html];
    }
}