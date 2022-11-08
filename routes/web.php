<?php

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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/product/{slug}', 'HomeController@single')->name('product.single');

Route::prefix('cart')->name('cart.')->group(function(){
    Route::get('/', 'CartController@index')->name('index');
    Route::post('add', 'CartController@add')->name('add');

    Route::get('remove/{slug}', 'CartController@remove')->name('remove');
    Route::get('cancel', 'CartController@Cancel')->name('cancel');
});


Route::prefix('checkout')->name('checkout.')->group(function (){
    Route::get('/', 'CheckoutController@index')->name('index');
});





Route::group(['middleware' => ['auth']], function(){
    Route::prefix('admin')->name('admin.')->namespace('Admin')->group(function (){

        //Route::prefix('stores')->name('stores.')->group(function (){

        // Route::get('/', 'StoreController@index')->name('index');
        // Route::get('/create', 'StoreController@create')->name('create');
        // Route::post('/store', 'StoreController@store')->name('store');
        // Route::get('/{store}/edit', 'StoreController@edit')->name('edit');
        // Route::post('/update/{store}', 'StoreController@update')->name('update');
        // Route::get('/destroy/{store}', 'StoreController@destroy')->name('destroy');
        //});

        Route::resource('stores', 'StoreController');
        Route::resource('products', 'ProductController');
        Route::resource('categories', 'CategoryController');

        Route::post('photos/remove/', 'ProductPhotoController@removePhoto')->name('photo.remove');
    });

});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');




Route::get('/model', function(){




    //$user = \App\User::find(4);

    //dd($user->store()->count());

    $loja = \App\Store::find(1);
    //return $loja->products()->where('id', 9) ->get();


    //criar uma loja pra um usuario
    //   $user = \App\User::find(10);
    //   $store = $user->store()->create([
    //       'name' => "Loja Teste",
    //       'description' => 'Loja teste de produtos de informatica',
    //       'mobile_phone' => 'xx-xxxx-xxxx',
    //       'phone' => 'xx-xxxx-xxxx',
    //       'slug' => 'loja-teste'
    //   ]);


    //criar um produto para uma loja
    //   $store = \App\Store::find(41);
    //   $product = $store->products()->create([
    //       'name' => 'Notebook Dell',
    //       'description' => 'CORE I5 10GB',
    //       'body'=> 'Qualquer coisa...',
    //       'price'=> 2999.90,
    //       'slug'=> 'notebook-dell',
    //   ]);



    // criar uma categoria

    //  \App\Category::create([
    //      'name' => 'Games',
    //      'description' => null,
    //      'slug' => 'notebooks'

    //]);
    // \App\Category::create([
    //    'name' => 'Games',
    //    'description' => null,
    //    'slug' => 'Games'

    //  ]);
    //  return \App\Category::all();


    //adicionar um produto para uma categoria ou vice-versa

    //  $product = \App\Product::find(9);

    //  dd($product->categories()->sync([2]));





    return \App\User::all();


});
