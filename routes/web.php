<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name('home')->middleware('auth');

Route::match(['get', 'post'], '/login', function () {
    if (request()->isMethod('post')) {
        $email = request()->input('email');
        $password = request()->input('password');

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            return redirect('/');
        } else {
            return redirect('/login')->withErrors(['email_pass' => 'Invalid email or password']);
        }
    } else {
        return view('login');
    }
})->name('login')->middleware('guest');

Route::match(['get', 'post'], '/register', function () {
    if (request()->isMethod('post')) {
        $name = request()->input('name');
        $email = request()->input('email');
        $password = request()->input('password');
        $password_confirmation = request()->input('password_confirmation');

        if ($password != $password_confirmation) {
            return redirect('/register')->withErrors(['password_confirmation' => 'Passwords do not match']);
        }

        $user = DB::select('SELECT * FROM users WHERE email = ?', [$email]);
        if (count($user) > 0) {
            return redirect('/register')->withErrors(['email' => 'Email already exists']);
        }

        $password = Hash::make($password);
        DB::insert('INSERT INTO users (name, email, password) VALUES (?, ?, ?)', [$name, $email, $password]);
        return redirect('/login');
    } else {
        return view('register');
    }
})->name('register')->middleware('guest');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout')->middleware('auth');

Route::match(['get', 'post'], '/change-password', function () {
    if (request()->isMethod('post')) {
        $old_password = request()->input('old_password');
        $new_password = request()->input('new_password');
        $new_password_confirmation = request()->input('new_password_confirmation');

        if ($new_password != $new_password_confirmation) {
            return redirect('/change-password')->withErrors(['new_password_confirmation' => 'Passwords do not match']);
        }

        $user = Auth::user();
        if (!Hash::check($old_password, $user->password)) {
            return redirect('/change-password')->withErrors(['old_password' => 'Invalid password']);
        }

        $new_password = Hash::make($new_password);
        DB::update('UPDATE users SET password = ? WHERE id = ?', [$new_password, $user->id]);
        return redirect('/');
    } else {
        return view('change_password');
    }
})->name('change-password')->middleware('auth');

// ================================ SECTIONS =================================
Route::get('/sections', function () {
    $data = DB::select('SELECT * FROM sections');
    return view('sections', ['sections' => $data]);
})->name('sections')->middleware('auth');

Route::get('/section/{id}', function (int $id) {
    $section = DB::select('SELECT * FROM sections WHERE id = ?', [$id]);
    if (count($section) > 0) {
        $employees = DB::select('SELECT * FROM users WHERE section_id = ?', [$section[0]->id]);
        $section[0]->employees = $employees;

        $products = DB::select('SELECT * FROM products WHERE section_id = ?', [$section[0]->id]);
        $section[0]->products = $products;

        return view('section', ['section' => $section[0]]);
    } else
        abort(404);

})->where('id', '[0-9]+')->name('section')->middleware('auth');

Route::match(['get', 'post'], '/section/{id}/edit', function (int $id) {
    if (request()->isMethod('post')) {
        $name = request()->input('name');
        DB::update('UPDATE sections SET name = ? WHERE id = ?', [$name, $id]);
        return redirect('/section/' . $id);
    } else {
        $data = DB::select('SELECT * FROM sections WHERE id = ?', [$id]);
        if (count($data) > 0)
            return view('section_edit', ['section' => $data[0]]);
        else
            abort(404);
    }

})->where('id', '[0-9]+')->name('section.edit')->middleware('auth');

Route::post('/sections/{id}/delete', function (int $id) {
    DB::delete('DELETE FROM sections WHERE id = ?', [$id]);
    return redirect('/sections');
})->where('id', '[0-9]+')->name('section.delete')->middleware('auth');

Route::match(['get', 'post'], '/section/create', function () {
    if (request()->isMethod('post')) {
        $name = request()->input('name');
        DB::insert('INSERT INTO sections (name) VALUES (?)', [$name]);
        return redirect('/sections');
    } else {
        return view('section_create');
    }
})->name('section.create')->middleware('auth');

// ================================ EMPLOYEES =================================
Route::get('/employees', function () {
    $data = DB::select("
        SELECT users.*, sections.name AS section_name
        FROM users
        LEFT JOIN sections ON users.section_id = sections.id
    ");

    return view('employees', ['employees' => $data]);
})->name('employees')->middleware('auth');

Route::get('/employee/{id}', function (int $id) {
    $data = DB::select('
        SELECT users.*, sections.name AS section_name
        FROM users
        LEFT JOIN sections ON users.section_id = sections.id
        WHERE users.id = ?
    ', [$id]);
    if (count($data) > 0)
        return view('employee', ['employee' => $data[0]]);
    else
        abort(404);
})->where('id', '[0-9]+')->name('employee')->middleware('auth');

Route::match(['get', 'post'], '/employee/{id}/edit', function (int $id) {
    if (request()->isMethod('post')) {
        $name = request()->input('name');
        $email = request()->input('email');
        $salary = request()->input('salary');
        $section = request()->input('section');
        DB::update('UPDATE users SET name = ?, email = ?, salary = ?, section_id = ? WHERE id = ?', [$name, $email, $salary, $section, $id]);
        return redirect('/employee/' . $id);
    } else {
        $data = DB::select('SELECT * FROM users WHERE id = ?', [$id]);
        $sections = DB::select('SELECT * FROM sections');

        if (count($data) > 0)
            return view('employee_edit', ['employee' => $data[0], 'sections' => $sections]);
        else
            abort(404);
    }

})->where('id', '[0-9]+')->name('employee.edit')->middleware('auth');

Route::post('/employee/{id}/delete', function (int $id) {
    $user = Auth::user();
    if ($user->id == $id) {
        DB::delete('DELETE FROM users WHERE id = ?', [$id]);
        Auth::logout();
        return redirect('/login');
    } else {
        return redirect('/employee' . $id);
    }
})->where('id', '[0-9]+')->name('employee.delete')->middleware('auth');

Route::match(['get', 'post'], '/employee/create', function () {
    if (request()->isMethod('post')) {
        $name = request()->input('name');
        $email = request()->input('email');
        $password = request()->input('password');
        $password_confirmation = request()->input('password_confirmation');
        $salary = request()->input('salary');
        $section = request()->input('section');

        if ($password != $password_confirmation) {
            return redirect('/employee/create')->withErrors(['password' => 'Passwords do not match']);
        }

        $user = DB::select('SELECT * FROM users WHERE email = ?', [$email]);
        if (count($user) > 0) {
            return redirect('/employee/create')->withErrors(['email' => 'Email already exists']);
        }

        $password = Hash::make($password);
        DB::insert('INSERT INTO users (name, email, password, salary, section_id) VALUES (?, ?, ?, ?, ?)', [$name, $email, $password, $salary, $section]);
        return redirect('/employees');
    } else {
        $sections = DB::select('SELECT * FROM sections');
        return view('employee_create', ['sections' => $sections]);
    }
})->name('employee.create')->middleware('auth');

// ================================ PRODUCTS =================================
Route::get('/products', function () {
    $data = DB::select("
        SELECT products.*, sections.name AS section_name
        FROM products
        JOIN sections ON products.section_id = sections.id
    ");

    return view('products', ['products' => $data]);
})->name('products')->middleware('auth');

Route::get('/product/{id}', function (int $id) {
    $data = DB::select('
        SELECT products.*, sections.name AS section_name
        FROM products
        JOIN sections ON products.section_id = sections.id
        WHERE products.id = ?
    ', [$id]);
    if (count($data) > 0)
        return view('product', ['product' => $data[0]]);
    else
        abort(404);
})->where('id', '[0-9]+')->name('product')->middleware('auth');

Route::match(['get', 'post'], '/product/{id}/edit', function (int $id) {
    if (request()->isMethod('post')) {
        $name = request()->input('name');
        $price = request()->input('price');
        $quantity = request()->input('quantity');
        $section = request()->input('section');
        DB::update('UPDATE products SET name = ?, price = ?, quantity = ?, section_id = ? WHERE id = ?', [$name, $price, $quantity, $section, $id]);
        return redirect('/product/' . $id);
    } else {
        $data = DB::select('SELECT * FROM products WHERE id = ?', [$id]);
        $sections = DB::select('SELECT * FROM sections');

        if (count($data) > 0)
            return view('product_edit', ['product' => $data[0], 'sections' => $sections]);
        else
            abort(404);
    }
})->where('id', '[0-9]+')->name('product.edit')->middleware('auth');

Route::post('/product/{id}/delete', function (int $id) {
    DB::delete('DELETE FROM products WHERE id = ?', [$id]);
    return redirect('/products');
})->where('id', '[0-9]+')->name('product.delete')->middleware('auth');

Route::match(['get', 'post'], 'product/create', function () {
    if (request()->isMethod('post')) {
        $name = request()->input('name');
        $price = request()->input('price');
        $quantity = request()->input('quantity');
        $section = request()->input('section');
        DB::insert('INSERT INTO products (name, price, quantity, section_id) VALUES (?, ?, ?, ?)', [$name, $price, $quantity, $section]);
        return redirect('/products');
    } else {
        $sections = DB::select('SELECT * FROM sections');
        return view('product_create', ['sections' => $sections]);
    }
})->name('product.create')->middleware('auth');
