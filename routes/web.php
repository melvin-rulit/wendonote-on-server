<?php


// My routes

Route::get('/catalog', 'CatalogController@ProdactionIndex')->name('prodaction.index');

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    //Route::delete('permissions/destroy', 'CatalogController@massDestroy')->name('permissions.massDestroy');
    //Route::resource('/', 'CatalogController');
    Route::get('/', 'CatalogController@index')->name('index');
    Route::post('/', 'CatalogController@store')->name('store');
    Route::post('/addArtist', 'CatalogController@addArtist')->name('addArtist');
    Route::post('/getGroup', 'CatalogController@getGroup')->name('getGroup');
    Route::get('artist/{artist}/edit', 'CatalogController@edit')->name('artist.edit');
    Route::post('/editid', 'CatalogController@editid')->name('editid');
    Route::post('/deleteid', 'CatalogController@deleteid')->name('deleteid');

    // Route::get('/admin', function () { return view('admin.catalog'); })->name('ad');
});



Route::get('/menu', 'MenuController@index')->name('menu.index');
Route::post('/menu-delete', 'MenuController@deleteMenu')->name('menu.delete');
Route::post('/menu-store', 'MenuController@store')->name('menu.store');
Route::post('/menu-info', 'MenuController@totalInfo')->name('menu.totalinfo');
Route::post('/menu-list', 'MenuController@menuList')->name('menu.menulist');

Route::post('/menu-getmenu', 'MenuController@getMenu')->name('menu.getmenu');

Route::post('/menu-deletegroup', 'MenuController@deleteGroup')->name('menu.deletegroup');
Route::post('/menu-storegroup', 'MenuController@addGroup')->name('menu.addgroup');



Route::post('/day-delete', 'DayController@deleteDay')->name('day.delete');
Route::post('/day-store', 'DayController@store')->name('day.store');
Route::post('/day-list', 'DayController@menuDay')->name('day.menulist');
Route::post('/day-getmenu', 'DayController@getDay')->name('day.getmenu');


Route::get('inivation/view/{id}', 'InivationController@user');

 Route::get('/inivation', 'InivationController@index');
 Route::post('/inivation-send', 'InivationController@send')->name('inivation.send');
 Route::post('/inivation-view', 'InivationController@view')->name('inivation.view');
 Route::post('/inivation-yes', 'InivationController@viewYes')->name('inivation.yes');
 Route::post('/inivation-edit', 'InivationController@edit')->name('inivation.edit');
 Route::post('/inivation-editsave', 'InivationController@editSave')->name('inivation.editsave');

// Route::post('/kalendar', 'CalendarController@send');
// Route::get('/kalendar', 'CalendarController@index');
// Route::post('/kalendar', 'CalendarController@store')->name('kalendar.store');

// Route::post('/kalendar', 'CalendarController@send')->name('kalendar.send');;
Route::get('/kalendar', 'CalendarController@index')->name('kalendar.index');
// Route::post('/kalendar', 'CalendarController@store')->name('kalendar.store');

Route::post('/inivation-store', 'InivationController@store')->name('inivation.store');


Route::post('/kalendar-send', 'CalendarController@send')->name('kalendar.send');
Route::post('/kalendar-store', 'CalendarController@store')->name('kalendar.store');
Route::post('/kalendar-delete', 'CalendarController@deleteJob')->name('kalendar.delete');

// My routes



Route::group(['middleware' => 'eventOnly'], function(){

    /* Temprorary static*/
    Route::get('/', function () { return view('pages.home'); })->name('home');

    Route::get('/mynote', function () { return view('pages.mynote'); })->name('mynote');
    //Route::get('/kalendar', function(){return view('pages.kalendar');})->name('kalendar');

    /* Dynamic and pages */
    Route::get('/joblist', 'JobsController@index')->name('joblist');
    Route::post('/joblist', 'JobsController@createJobCategory');

    Route::get('/notes', 'NotesController@index')->name('notes');
    Route::post('/notes', 'NotesController@createNoteCategory');
    Route::get('/guests', 'GuestsController@index')->name('visitors_list');
    Route::get('/contacts', 'ContactController@index')->name('contact_list');
    Route::get('/day', 'DayController@index')->name('day');


    /* Ajax methods */

    Route::group(['prefix' => 'ajax'], function() {

        //NOTES
        Route::post('/swapNotes', 'NotesController@swapNotes');

        Route::post('/getNoteData', 'NotesController@getNote');
        Route::post('/saveNoteData', 'NotesController@saveNote');

        Route::post('/getNewNoteData', 'NotesController@getNewNoteData');
        Route::post('/createNewNote', 'NotesController@createNewNote');

        Route::post('/deleteNote', 'NotesController@deleteNote');
        Route::post('/deleteNoteOnly', 'NotesController@deleteNoteOnly');
        Route::post('/sendCalendarOnly', 'NotesController@sendCalendarOnly');
        Route::post('/setNoteDone', 'NotesController@setNoteDone');
        Route::post('/setNoteNotDone', 'NotesController@setNoteNotDone');

        Route::post('/getNoteCards', 'NotesController@getNoteCards');

        Route::post('/deleteNoteCategory', 'NotesController@deleteNoteCategory');



        //JOBS
        Route::post('/swapJobs', 'JobsController@swapJobs');

        Route::post('/getJobData', 'JobsController@getJob');
        Route::post('/saveJobData', 'JobsController@saveJob');

        Route::post('/getNewJobData', 'JobsController@getNewJobData');
        Route::post('/createNewJob', 'JobsController@createNewJob');

        Route::post('/deleteJob', 'JobsController@deleteJob');
        Route::post('/deleteJobOnly', 'JobsController@deleteJobOnly');
        Route::post('/sendCalendarOnly', 'JobsController@sendCalendarOnly');
        Route::post('/setJobDone', 'JobsController@setJobDone');
        Route::post('/setJobNotDone', 'JobsController@setJobNotDone');

        Route::post('/getJobCards', 'JobsController@getJobCards');

        Route::post('/deleteJobCategory', 'JobsController@deleteJobCategory');

        //GUESTS
        Route::get('/getGuestNumbers', 'GuestsController@getGuestNumbers');
        Route::post('/setGuest', 'GuestsController@setGuest');

        //GUESTS CONTACTS
        Route::get('/getGuestContacts', 'GuestsController@getGuestContacts');
        Route::post('/updateGuestContacts', 'GuestsController@updateGuestContacts');

        //CONTACTS
        Route::post('/setContact', 'ContactController@setContact');
        Route::get('/getContacts', 'ContactController@getContacts');
        Route::post('/updateContacts', 'ContactController@updateContacts');

    });

    

});

Route::group(['middleware' => 'noEventOnly'], function(){
    Route::get('/create_wedding', 'WeddingController@getCreateWeddingPage')->name('wedding-create');
    Route::post('/create_wedding', 'WeddingController@postCreateWeddingPage');
});

/* Auth routes */

Route::group(['middleware' => 'guest'], function(){

    /*Route::get('/login', 'Auth\AuthController@get')*/

    Route::get('/register', 'Auth\AuthController@getRegisterPage')->name('register');
    Route::get('/login', 'Auth\AuthController@getLoginPage')->name('login');

    Route::get('/choose-role', function(){
        return view('auth.choose-role');
    })->name('choose-role');

    Route::get('/recovery', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('recovery');
    Route::post('/recovery', 'Auth\ForgotPasswordController@sendResetLinkEmail');

    Route::get('/submitRecovery', 'Auth\ResetPasswordController@showResetForm')->name('new_password');
    Route::post('/submitRecovery', 'Auth\ResetPasswordController@reset');

    Route::post('/register', 'Auth\AuthController@postRegisterPage')->name('post-register');
    Route::post('/login', 'Auth\AuthController@postLoginPage')->name('post-login');

});

Route::get('/logout', 'Auth\AuthController@logout')->name('logout');

/* End of auth routes */



