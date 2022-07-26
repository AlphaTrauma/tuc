<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Image;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    // Регистрация студента через панель админа
    public function add(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:25'],
            'last_name' => ['required', 'string', 'max:25'],
            'patronymic' => ['nullable', 'string', 'max:25'],
            'phone' => ['nullable', 'string', 'max:15'],
            'organization' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users']
        ]);

        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'patronymic' => $request->patronymic,
            'phone' => $request->phone,
            'organization' => $request->organization,
            'email' => $request->email,
            'password' => 'default'
        ]);
        $password = Str::slug($user->last_name).Str::slug($user->name)[0].'@'.$user->id;
        $user->update(['password' => Hash::make($password)]);

        event(new Registered($user));

        $message = 'Регистрация нового пользователя:'.PHP_EOL.
            $user->name.' '.$user->last_name.PHP_EOL.
            'Логин: '.$user->email.PHP_EOL.
            'Пароль: '.$password;
        $data = [
            'chat_id' => '-1001708032534',
            'parse_mode' => 'HTML',
            'text' => $message
        ];
        $response = file_get_contents("https://api.telegram.org/bot5344836009:AAGH0z3JJdlfN10sNjK_457a_2C_mFrNc1k/sendMessage?".
            http_build_query($data) );

        return back()->with('message', 'Пользователь успешно зарегистрирован. Логин: '.$user->email.' Пароль: '.$password);
    }

    public function index(Request $request)
    {
        $users = User::query()->orderBy('id', 'desc');
        if($request->has('search')):
            $query = $request->input('search');
            $users->where('email', 'like', '%'.$query.'%')->orWhere('last_name', 'like', '%'.$query.'%');
        endif;
        $users = $users->paginate(100);

        return view('dashboard.users.index', compact('users'));
    }

    public function students(Request $request)
    {
        $users = User::with('user_courses.course')->where('role', 'student')->orderBy('id', 'desc');
        $courses = Course::query()->orderBy('title')->pluck('title', 'id')->toArray();
        if($request->has('search')):
            $query = $request->input('search');
            $users->where('email', 'like', '%'.$query.'%')->orWhere('last_name', 'like', '%'.$query.'%');
        endif;
        $users = $users->paginate(50);

        return view('dashboard.users.students', compact('users', 'courses'));
    }

    public function show($id)
    {
        $item = User::find($id);

        return view('dashboard.users.show', compact('item'));
    }

    public function edit($id)
    {
        $item = User::find($id);

        return view('dashboard.users.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = User::find($id);

        $data = $request->except('_token');
        if($request->has('pass')):
            $data['password'] = Hash::make($data['pass']);
        endif;
        $item->update($data);
        if($request->hasFile('file')):
            Image::add($request->file('file'), 'users/'.$item->id, $item);
        endif;

        return redirect()->route('users')->with('message', 'Данные пользователя успешно изменены');
    }
}
