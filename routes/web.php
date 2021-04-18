<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\TypeBagHourController;
use App\Http\Controllers\CustomerController;

use App\Http\Controllers\LocalizationController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//Route::get('/', [LocalizationController::class, "index"]);
//Route::get('change/lang', [LocalizationController::class, "lang_change"])->name('LangChange');




Route::view("/", "home")->name('home');
Route::view("/company-info", "company-info")->name('company-info');

//Route::resource('customers', CustomerController::class);
Route::resource('type-bag-hours', TypeBagHourController::class);

Route::post("customers/{customer}/lang/{lang}", [CustomerController::class, 'update'])->name('customers.update');
Route::post('customers/delete_filters', [CustomerController::class, 'deleteFilters'])->name('customers.delete_filters');
Route::post("customers/{lang}", [CustomerController::class, 'store'])->name('customers.store');

Route::get("en/customers", [CustomerController::class, 'index'])->name('en_customers.index');
Route::get("en/customers/create", [CustomerController::class, 'create'])->name('en_customers.create');
Route::get("en/customers/{customer}/edit", [CustomerController::class, 'edit'])->name('en_customers.edit');
Route::delete("en/customers/{customer}", [CustomerController::class, 'destroy'])->name('en_customers.destroy');




//Route::post("es/clientes/guardar", [CustomerController::class, 'store'])->name('es_customers.store');
//
//
//
////Route::get("/portafolio/crear", "ProjectController@create")->name('projects.create');
//Route::post("/portafolio", "ProjectController@store")->name('projects.store');

//Route::get("es/clientes", [CustomerController::class, 'index'])->name('es_customers.index');
//Route::get("es/clientes/crear", [CustomerController::class, 'create'])->name('es_customers.create');
//Route::post("es/clientes/guardar", [CustomerController::class, 'store'])->name('es_customers.store');


Route::post('type-bag-hours/delete_filters', [TypeBagHourController::class, 'deleteFilters'])->name('type-bag-hours.delete_filters');



