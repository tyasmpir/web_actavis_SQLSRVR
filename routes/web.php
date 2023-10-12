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

// Default Auth Laravel
Route::get('/', function () {
	if(Auth::check()){return Redirect::to('home');}
    return view('auth.login');
});

Route::group(['middleware' => ['auth']], function() {
	Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
     
     
    // Dash
    route::get('/openwo', 'dashController@openwo');
    route::get('/planwo', 'dashController@planwo');
    route::get('/startwo', 'dashController@startwo');
    route::get('/finishwo', 'dashController@finishwo');
    route::get('/closewo', 'dashController@closewo');
    route::get('/itemrfqset', 'dashController@itemrfqset');
	route::get('/problemwo/{asset}', 'dashController@problemwo');
	route::get('/problemwo/{asset}/pagination', 'dashController@problemwopaging');
	route::get('/wotype/{desc}', 'dashController@wotypeget');
	route::get('/wotype/{desc}/pagination', 'dashController@wotypepaging');
	route::get('/woeng/{eng}', 'dashController@woengget');
	route::get('/woeng/{eng}/pagination', 'dashController@woengpaging');
	route::get('/datagrafwo/{desc}', 'dashController@datagrafwo');
	route::get('/datagrafwo/{desc}/pagination', 'dashController@datagrafwopaging');
	route::get('/datagrafytdwo/{desc}', 'dashController@datagrafytdwo');
	route::get('/datagrafytdwo/{desc}/pagination', 'dashController@datagrafytdwopaging');	
	route::get('/datagrafhourwo/{desc}', 'dashController@datagrafhourwo');
	route::get('/datagrafhourwo/{desc}/pagination', 'dashController@datagrafhourwopaging');
	route::get('/wostatus/{desc}', 'dashController@wostatus');
	route::get('/wostatus/{desc}/pagination', 'dashController@wostatuspaging');
	route::get('/getfinhour', 'dashController@getfinhour');
	route::get('/donlodwograf','dashController@donlodwograf'); 

    // User Maint
	route::get('/usermt', 'SettingController@usermenu');
	route::post('/createuser', 'SettingController@createuser');
	route::get('/usermt/pagination', 'SettingController@userpaging');
	route::get('/cekuser', 'SettingController@cekuser');
	route::post('/edituser','SettingController@edituser'); /*21 Sept 2020*/
	route::post('/deleteuser','SettingController@deleteuser'); /*21 Sept 2020*/
	route::get('/menuuser','SettingController@getmenuuser'); /*23 Sept 2020*/
	route::get('/changepassword', 'SettingController@indchangepass');
	route::post('/userchange/changepass', 'SettingController@changepass');
     
     

	// Role Maint
	route::get('/rolemaster', 'SettingController@rolemenu');
	route::post('/createrole', 'SettingController@createrole');
	route::get('/cekrole', 'SettingController@cekrole');
	route::get('/cekrole2', 'SettingController@cekrole2');
	route::post('/editrole','SettingController@editrole');
	route::post('/deleterole','SettingController@deleterole');
	route::get('/rolesearch', 'SettingController@rolesearch');
	route::get('/menugetrole','SettingController@menugetrole');
	route::get('/rolemaster/pagination', 'SettingController@rolepaging');

	//site master
	route::get('/sitemaster', 'SettingController@sitemaster');
	route::get('/ceksite', 'SettingController@ceksite');
	route::post('/createsite', 'SettingController@createsite');
	route::post('/editsite', 'SettingController@editsite');
	route::post('/deletesite', 'SettingController@deletesite');
	route::get('/sitesearch', 'SettingController@sitesearch');
	route::get('/sitemaster/pagination', 'SettingController@sitepagination');

	//area master
	route::get('/areamaster', 'SettingController@areamaster');
	route::get('/cekarea', 'SettingController@cekarea');
	route::post('/createarea', 'SettingController@createarea');
	route::post('/editarea', 'SettingController@editarea');
	route::post('/deletearea', 'SettingController@deletearea');
	route::get('/areasearch', 'SettingController@areasearch');
	route::get('/areamaster/pagination', 'SettingController@areapagination');

	//asset type master
	route::get('/assettypemaster', 'SettingController@assettypemaster');
	route::get('/cekassettype', 'SettingController@cekassettype');
	route::post('/createassettype', 'SettingController@createassettype');
	route::post('/editassettype', 'SettingController@editassettype');
	route::post('/deleteassettype', 'SettingController@deleteassettype');
	route::get('/assettypesearch', 'SettingController@assettypesearch');
	route::get('/assettypemaster/pagination', 'SettingController@assettypepagination');

	//asset group master
	route::get('/assetgroupmaster', 'SettingController@assetgroupmaster');
	route::get('/cekassetgroup', 'SettingController@cekassetgroup');
	route::post('/createassetgroup', 'SettingController@createassetgroup');
	route::post('/editassetgroup', 'SettingController@editassetgroup');
	route::post('/deleteassetgroup', 'SettingController@deleteassetgroup');
	route::get('/assetgroupsearch', 'SettingController@assetgroupsearch');
	route::get('/assetgroupmaster/pagination', 'SettingController@assetgrouppagination');

	//failure master
	route::get('/fnmaster', 'SettingController@fnmaster');
	route::get('/cekfn', 'SettingController@cekfn');
	route::post('/createfn', 'SettingController@createfn');
	route::post('/editfn', 'SettingController@editfn');
	route::post('/deletefn', 'SettingController@deletefn');
	route::get('/fnsearch', 'SettingController@fnsearch');
	route::get('/fnmaster/pagination', 'SettingController@fnpagination');

	//supplier master
	route::get('/suppmaster', 'SettingController@suppmaster');
	route::get('/ceksupp', 'SettingController@ceksupp');
	route::post('/createsupp', 'SettingController@createsupp');
	route::post('/editsupp', 'SettingController@editsupp');
	route::post('/deletesupp', 'SettingController@deletesupp');
	route::get('/suppsearch', 'SettingController@suppsearch');
	route::get('/suppmaster/pagination', 'SettingController@supppagination');

	//asset master
	route::get('/assetmaster', 'SettingController@assetmaster');
	route::get('/cekasset', 'SettingController@cekasset');
	route::post('/createasset', 'SettingController@createasset');
	route::post('/editasset', 'SettingController@editasset');
	route::post('/deleteasset', 'SettingController@deleteasset');
	route::get('/assetsearch', 'SettingController@assetsearch');
	route::get('/assetmaster/pagination', 'SettingController@assetpagination');
	route::get('/locasset', 'SettingController@locasset');
	route::get('/locasset2', 'SettingController@locasset2');
	route::get('/repaircode', 'SettingController@repaircode');
	route::get('/downloadfile/{id}', 'SettingController@downloadfile');
	route::get('/listupload/{id}', 'SettingController@listupload')->name('listupload');
	route::get('/deleteupload/{id}', 'SettingController@deleteupload');


	//asset parent
	route::get('/asparmaster', 'SettingController@asparmaster');
	route::post('/createaspar', 'SettingController@createaspar');
	route::post('/editaspar', 'SettingController@editaspar');
	route::get('/editdetailaspar', 'SettingController@editdetailaspar');
	route::post('/deleteaspar', 'SettingController@deleteaspar');
	route::get('/asparsearch', 'SettingController@asparsearch');
	route::get('/asparmaster/pagination', 'SettingController@asparpagination');
     
    //Reparit group
	route::get('/repgroup', 'RepController@repgroup');
    route::post('/createrepgroup', 'RepController@createrepgroup');
    route::post('/editrepgroup', 'RepController@editrepgroup');
	route::post('/deleterepgroup', 'RepController@deleterepgroup');
	route::get('/repgroup/pagination', 'RepController@repgrouppagination');
	route::get('/detailrepgroup', 'RepController@detailrepgroup');
	route::get('/editdetailrepgroup', 'RepController@editdetailrepgroup'); 

	// repair code
	route::get('/repcode', 'SettingController@repcode');
    route::post('/createrepcode', 'SettingController@createrepcode');
    route::post('/editrepcode', 'SettingController@editrepcode');
	route::post('/deleterepcode', 'SettingController@deleterepcode');
	route::get('/repcode/pagination', 'SettingController@repcodepagination');
	route::get('/detailrepcode', 'SettingController@detailrepcode');
	route::get('/editdetailrepcode', 'SettingController@editdetailrepcode'); 
     
	//spare part type master
	route::get('/sptmaster', 'SettingController@sptmaster');
	route::get('/cekspt', 'SettingController@cekspt');
	route::post('/createspt', 'SettingController@createspt');
	route::post('/editspt', 'SettingController@editspt');
	route::post('/deletespt', 'SettingController@deletespt');
	route::get('/sptsearch', 'SettingController@sptsearch');
	route::get('/sptmaster/pagination', 'SettingController@sptpagination');

	//spare part type group
	route::get('/spgmaster', 'SettingController@spgmaster');
	route::get('/cekspg', 'SettingController@cekspg');
	route::post('/createspg', 'SettingController@createspg');
	route::post('/editspg', 'SettingController@editspg');
	route::post('/deletespg', 'SettingController@deletespg');
	route::get('/spgsearch', 'SettingController@spgsearch');
	route::get('/spgmaster/pagination', 'SettingController@spgpagination');

	//spare part master
	route::get('/spmmaster', 'SettingController@spmmaster');
	route::get('/cekspm', 'SettingController@cekspm');
	route::post('/createspm', 'SettingController@createspm');
	route::post('/editspm', 'SettingController@editspm');
	route::post('/deletespm', 'SettingController@deletespm');
	route::get('/spmsearch', 'SettingController@spmsearch');
	route::get('/spmmaster/pagination', 'SettingController@spmpagination');

	//tool master
	route::get('/toolmaster', 'SettingController@toolmaster');
	route::get('/cektool', 'SettingController@cektool');
	route::post('/createtool', 'SettingController@createtool');
	route::post('/edittool', 'SettingController@edittool');
	route::post('/deletetool', 'SettingController@deletetool');
	route::get('/toolsearch', 'SettingController@toolsearch');
	route::get('/toolmaster/pagination', 'SettingController@toolpagination');

	//repair master
	route::get('/repmaster', 'SettingController@repmaster');
	route::get('/cekrep', 'SettingController@cekrep');
	route::post('/createrep', 'SettingController@createrep');
	route::post('/editrep', 'SettingController@editrep');
	route::post('/deleterep', 'SettingController@deleterep');
	route::get('/repsearch', 'SettingController@repsearch');
	route::get('/repmaster/pagination', 'SettingController@reppagination');

	//repair master b
	route::get('/repmasterb', 'SettingController@repmasterb');
	route::get('/cekrepb', 'SettingController@cekrepb');
	route::post('/createrepb', 'SettingController@createrepb');
	route::post('/editrepb', 'SettingController@editrepb');
	route::post('/deleterepb', 'SettingController@deleterepb');
	route::get('/repsearchb', 'SettingController@repsearchb');
	route::get('/repmasterb/pagination', 'SettingController@reppaginationb');

	//instruction Detail
	route::get('/insmaster', 'SettingController@insmaster');
	route::get('/cekins', 'SettingController@cekins');
	route::get('/viewtool', 'SettingController@viewtool');
	route::get('/viewpart', 'SettingController@viewpart');
	route::post('/createins', 'SettingController@createins');
	route::post('/editins', 'SettingController@editins');
	route::post('/deleteins', 'SettingController@deleteins');
	route::get('/inssearch', 'SettingController@inssearch');
	route::get('/insmaster/pagination', 'SettingController@inspagination');

	//instruction Group
	route::get('/insgroup', 'SettingController@insgroup');
	route::get('/cekinsg', 'SettingController@cekinsg');
	route::get('/viewtool', 'SettingController@viewtool');
	route::post('/createinsg', 'SettingController@createinsg');
	route::get('/editinsgroup', 'SettingController@editinsgroup');
	route::post('/editinsg', 'SettingController@editinsg');
	route::post('/deleteinsg', 'SettingController@deleteinsg');
	route::get('/insgsearch', 'SettingController@insgsearch');
	route::get('/insgroup/pagination', 'SettingController@insgpagination');

	//repair part
	route::get('/reppart', 'SettingController@reppart');
	route::get('/cekreppart', 'SettingController@cekreppart');
	route::post('/createreppart', 'SettingController@createreppart');
	route::post('/editreppart', 'SettingController@editreppart');
	route::post('/deletereppart', 'SettingController@deletereppart');
	route::get('/reppartsearch', 'SettingController@reppartsearch');
	route::get('/reppart/pagination', 'SettingController@reppartpagination');
	route::get('/detailreppart', 'SettingController@detailreppart');
	route::post('/deletedetailreppart', 'SettingController@deletedetailreppart');

	//repair part group
	route::get('/reppartgroup', 'SettingController@reppartgroup');
	route::get('/cekreppg', 'SettingController@cekreppg');
	route::post('/createreppg', 'SettingController@createreppg');
	route::get('/editreppgroup', 'SettingController@editreppgroup');
	route::post('/editreppg', 'SettingController@editreppg');
	route::post('/deletereppg', 'SettingController@deletereppg');
	route::get('/reppgsearch', 'SettingController@reppgsearch');
	route::get('/reppartgroup/pagination', 'SettingController@reppgpagination');

	//repair instruction
	route::get('/repins', 'SettingController@repins');
	route::get('/cekrepins', 'SettingController@cekrepins');
	route::post('/createrepins', 'SettingController@createrepins');
	route::post('/editrepins', 'SettingController@editrepins');
	route::post('/deleterepins', 'SettingController@deleterepins');
	route::get('/repinssearch', 'SettingController@repinssearch');
	route::get('/repins/pagination', 'SettingController@repinspagination');
	route::get('/detailrepins', 'SettingController@detailrepins');
	route::post('/deletedetailrepins', 'SettingController@detailrepins');

	//repair detail 
	route::get('/repdet', 'SettingController@repdet');
	route::get('/cekrepdet', 'SettingController@cekrepdet');
	route::post('/createrepdet', 'SettingController@createrepdet');
	route::post('/editrepdet', 'SettingController@editrepdet');
	route::post('/deleterepdet', 'SettingController@deleterepdet');
	route::get('/repdetsearch', 'SettingController@repdetsearch');
	route::get('/repdet/pagination', 'SettingController@repdetpagination');
	route::get('/detailrepdet', 'SettingController@detailrepdet');
	route::post('/deletedetailrepdet', 'SettingController@deletedetailrepdet');

	//inventory
	route::get('/inv', 'SettingController@inv');
	route::get('/cekinv', 'SettingController@cekinv');
	route::post('/createinv', 'SettingController@createinv');
	route::post('/editinv', 'SettingController@editinv');
	route::post('/deleteinv', 'SettingController@deleteinv');
	route::get('/invsearch', 'SettingController@invsearch');
	route::get('/inv/pagination', 'SettingController@invpagination');

	//engineering master
	route::get('/engmaster', 'SettingController@engmaster');
	route::get('/cekeng', 'SettingController@cekeng');
	route::post('/createeng', 'SettingController@createeng');
	route::post('/editeng', 'SettingController@editeng');
	route::post('/deleteeng', 'SettingController@deleteeng');
	route::get('/engsearch', 'SettingController@engsearch');
	route::get('/engmaster/pagination', 'SettingController@engpagination');
	route::get('/engskill', 'SettingController@engskill');
	route::get('/engrole', 'SettingController@engrole');
	route::get('/engrole2', 'SettingController@engrole2');
	
	//departemen master
	route::get('/deptmaster', 'SettingController@deptmaster');
	route::get('/cekdept', 'SettingController@cekdept');
	route::post('/createdept', 'SettingController@createdept');
	route::post('/editdept', 'SettingController@editdept');
	route::post('/deletedept', 'SettingController@deletedept');
	route::get('/deptsearch', 'SettingController@deptsearch');
	route::get('/deptmaster/pagination', 'SettingController@deptpagination');

	
	//skill master
	route::get('/skillmaster', 'SettingController@skillmaster');
	route::get('/cekskill', 'SettingController@cekskill');
	route::post('/createskill', 'SettingController@createskill');
	route::post('/editskill', 'SettingController@editskill');
	route::post('/deleteskill', 'SettingController@deleteskill');
	route::get('/skillsearch', 'SettingController@skillsearch');
	route::get('/skillmaster/pagination', 'SettingController@skillpagination');

	//report
	Route::get('users', 'UserChartController@index');
	Route::get('/rptwo', 'UserChartController@rptwo');
	Route::get('/topten', 'UserChartController@topten');
	Route::get('/topprob', 'UserChartController@topprob');
	route::get('/topprob/pagination', 'UserChartController@topprobpagination');
	route::get('/detailtopprob', 'UserChartController@detailtopprob');
	route::get('/tophealthy', 'UserChartController@tophealthy');
	route::get('/engsch', 'UserChartController@engsch');
    route::get('/allrpt', 'UserChartController@allrpt');
	route::get('/engsch1', 'UserChartController@engsch1');
	route::get('/engsch2', 'UserChartController@engsch2');
	route::get('/assetrpt', 'UserChartController@assetrpt');
	route::get('/bookcal', 'UserChartController@bookcal');
	route::post('/bookcal', 'UserChartController@bookcal');
	route::get('/assetsch', 'UserChartController@assetsch');
	route::post('/assetsch', 'UserChartController@assetsch');
	route::get('/engrpt', 'UserChartController@engrpt');
	route::get('/engrptview', 'UserChartController@engrptview');
	route::get('/assetrpt', 'UserChartController@assetrpt');
	route::get('/assetrptview', 'UserChartController@assetrptview');
	route::get('/assetgraf', 'UserChartController@assetgraf');
	route::get('/enggraf', 'UserChartController@enggraf');
	route::get('/wostat', 'UserChartController@wostat'); /** 2023.10.12 Menampilkan laporan jumlah status WO yang sudah terbentuk */

	//work order maintenance
	route::get('/womaint', 'wocontroller@wobrowse')->name('womaint');
	route::post('/createwo', 'wocontroller@createwo');
	route::get('/womaint/pagination', 'wocontroller@wopaging');
	route::post('/editwo','wocontroller@editwo'); 
	route::post('/editwoeng','wocontroller@editwoeng'); 
	route::post('/closewo','wocontroller@closewo'); 
	route::get('/womaint/getnowo','wocontroller@geteditwo');
	route::get('/womaint/getfailure','wocontroller@getfailure');
	route::post('/approvewo','wocontroller@approvewo'); 
	route::get('/openprint/{wo}','wocontroller@openprint');
	route::get('/openprint2/{wo}','wocontroller@openprint2');
	route::get('/wodownloadfile/{wo}','wocontroller@downloadfile');
	route::get('/wobrowseopen', 'wocontroller@wobrowseopen'); //tyas, link dari Home 
	route::get('/womaintpage','wocontroller@womaintpage')->name('womaintpage'); //fungsi untuk menampung page yang sama setelah submit
	
	//work order start
	route::get('/wojoblist', 'wocontroller@wojoblist')->name('wojoblist');
	route::post('/editjob', 'wocontroller@editjob');
	route::get('/wojoblist/pagination', 'wocontroller@wopagingstart')->name('wojoblistpage');
	route::get('/wostart', 'wocontroller@wojobliststart')->name('wojobliststart'); //fungsi untuk menampung page yang sama setelah submit

	//wo reporting and close
	route::get('/woreport', 'wocontroller@wocloselist')->name('woreport');
	route::post('/reportingwo', 'wocontroller@reportingwo');
	route::post('/reportingwoother', 'wocontroller@reportingwoother'); //reporting untuk selain type auto
	route::post('/reopenwo', 'wocontroller@reopenwo');
	route::get('/getrepair1/{wo}', 'wocontroller@getrepair1');
	route::get('/getrepair2/{wo}', 'wocontroller@getrepair2');
	route::get('/getrepair3/{wo}', 'wocontroller@getrepair3');
	route::get('/getgroup1/{wo}', 'wocontroller@getgroup1');
	route::post('/statusreportingwo', 'wocontroller@statusreportingwo');
	route::get('/woreport/pagination', 'wocontroller@wopagingreport');
	route::get('/downloadwofinish/{id}', 'wocontroller@downloadwofinish'); // untuk donload file dari wo finish
	route::get('/delfilewofinish/{id}', 'wocontroller@delfilewofinish'); // untuk delete file wo finish dari approval spv`
	route::get('/woreportpage', 'wocontroller@woreportpage')->name('woreportpage'); //fungsi untuk menampung page yang sama setelah submit

	


	//13-08-2021
	route::get('/homegraf','HomeController@grafmajumundur');

	//work order create
	route::get('/wocreatemenu', 'wocontroller@wocreatemenu')->name('wocreatemenu');
	route::get('/wocreate/pagination', 'wocontroller@wopagingcreate');
	route::post('/createenwo', 'wocontroller@createenwo');

	//work order browse
	route::get('/wobrowse', 'wocontroller@wobrowsemenu')->name('wobrowse');
	route::get('/wobrowse/pagination', 'wocontroller@wopagingview');
	route::get('/donlodwo','wocontroller@donlodwo'); //tyas, nambahin excel
	
	//work order direct
	route::get('/wocreatedirectmenu', 'wocontroller@wocreatedirectmenu')->name('wocreatedirectmenu');
	route::get('/wocreatedirect/pagination', 'wocontroller@wopagingcreatedirect');
	route::post('/createdirectwo', 'wocontroller@createdirectwo');
	route::post('/editwodirect','wocontroller@editwodirect');

	// Schedule + Usage MT -- 03242021
	route::get('usagemt','UsageController@index');
	route::post('updateusage','UsageController@updateusage');
	Route::post('/mark-as-read', 'UsageController@notifread')->name('notifread');
	Route::post('/mark-all-as-read', 'UsageController@notifreadall')->name('notifreadall');
	route::get('usagemulti','UsageController@usagemulti');
	route::post('updateusagemulti','UsageController@updateusagemulti');
	route::get('/usageneedmt','UsageController@usageneedmt');
	route::post('batchwo','UsageController@batchwo');

	// bagian tommy
	route::get('/servicerequest', 'ServiceController@servicerequest')->name('srcreate');
	route::post('/inputsr', 'ServiceController@inputsr');
	route::get('/failuresearch','ServiceController@failuresearch');
	route::get('/srapproval', 'ServiceController@srapproval');
	route::get('/engineersearch','ServiceController@engajax');
	route::post('/approval', 'ServiceController@approval');
	route::get('/srapproval/searchapproval', 'ServiceController@searchapproval');
	route::get('/searchimpactdesc', 'ServiceController@searchimpact');


	//bagian tommy sr browse
	route::get('/srbrowse', 'ServiceController@srbrowse');
	route::get('/srbrowse/searchsr', 'ServiceController@searchsr');
	route::get('/srbrowseopen', 'ServiceController@srbrowseopen'); //tyas, link dari Home
	route::get('/donlodsr','ServiceController@donlodsr'); //tyas, excel SR
	route::get('/useracceptance', 'ServiceController@useracceptance'); 
	route::post('/acceptance', 'ServiceController@acceptance');
	route::get('/useracceptance/search', 'ServiceController@useracceptancesearch');

	//running number tommy
	route::get('/runningmstr', 'SettingController@runningmstr');
	route::post('/updaterunning', 'SettingController@updaterunning');

	//image tommy
	route::get('/imageview', 'ServiceController@imageview');

	// 27.07.2021 booking tyas
	route::get('/booking', 'BookingController@booking');
   route::post('/createbooking', 'BookingController@createbooking');
   route::post('/editbooking', 'BookingController@editbooking');
   route::post('/appbooking', 'BookingController@appbooking');
   route::post('/deletebooking', 'BookingController@deletebooking');
   route::post('/cekbooking', 'BookingController@cekbooking');
   route::get('/booking/pagination', 'BookingController@bookingpage');
   
   // wo type main
   route::get('/wotyp', 'wotypController@home');
   route::post('/createwotyp', 'wotypController@create');
	route::post('/editwotyp', 'wotypController@edit');
	route::post('/deletewotyp', 'wotypController@delete');
   
    // imp main
   route::get('/imp', 'impController@home');
   route::post('/createimp', 'impController@create');
	route::post('/editimp', 'impController@edit');
	route::post('/deleteimp', 'impController@delete');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');