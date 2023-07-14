<?php

use App\Http\Controllers\Master\AssetSiteController;
use App\Http\Controllers\Master\AssetLocController;
use App\Http\Controllers\Master\AssetMoveController;
use App\Http\Controllers\Master\PmEngController;
use App\Http\Controllers\Master\UMController;
use App\Http\Controllers\Master\AsfnController;
use App\Http\Controllers\Master\EngGroupContoller;
use App\Http\Controllers\Master\PMCodeController;
use App\Http\Controllers\Master\QCSpecController;
use App\Http\Controllers\Master\InsListController;
use App\Http\Controllers\Master\SplistController;
use App\Http\Controllers\Master\PmassetController;
use App\Http\Controllers\Master\RcmMstrController;
use App\Http\Controllers\Master\AppSrController;
use App\Http\Controllers\Master\AppWoController;
use App\Http\Controllers\Master\InvSoController;
use App\Http\Controllers\Master\InvSuController;
use App\Http\Controllers\Master\NotmssgController;
use App\Http\Controllers\Report\RptDetWOController;
use App\Http\Controllers\Report\RptCostController;
use App\Http\Controllers\Report\RemainSpController;
use App\Http\Controllers\Report\RptAssetYearController;
use App\Http\Controllers\SP\KebutuhanSPController;
use App\Http\Controllers\UserChartController;
use App\Http\Controllers\WO\AllWOGenerate;
use App\Http\Controllers\WO\ConfirmEng;
use App\Http\Controllers\WO\WORelease;
use App\Http\Controllers\WO\WHSConfirm;
use App\Http\Controllers\WO\PMdetsController;
use App\Http\Controllers\WO\WoQcController;
use App\Http\Controllers\Usage\UsageBrowseController;
use App\Http\Controllers\Usage\PmConfirmController;
use App\Http\Controllers\Usage\PmmssgController;
use App\Http\Controllers\Other\WhyHistController;
use App\Http\Controllers\Routine\RoutineCheckController;
use App\Http\Controllers\SparepartController;
use App\Http\Controllers\wocontroller;
use App\KebutuhanSP;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Master\QxWsaMTController;
use Illuminate\Support\Facades\Route;

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
    // route::get('/closewo', 'dashController@closewo');
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
	route::post('/loadsite', 'SettingController@loadsite');
	route::get('/sitemaster/pagination', 'SettingController@sitepagination');

	//area master
	route::get('/areamaster', 'SettingController@areamaster');
	route::get('/cekarea', 'SettingController@cekarea');
	route::post('/createarea', 'SettingController@createarea');
	route::post('/editarea', 'SettingController@editarea');
	route::post('/deletearea', 'SettingController@deletearea');
	route::get('/areasearch', 'SettingController@areasearch');
	route::post('/loadloc', 'SettingController@loadloc');
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
	route::post('/loadsupp', 'SettingController@loadsupp');

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
	route::get('/setlistupload/{id}', 'SettingController@listupload')->name('setlistupload');
	route::get('/deleteupload/{id}', 'SettingController@deleteupload');
	route::get('/excelasset', 'SettingController@excelasset'); // untuk download data asset ke excel -> menu master asset


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
	route::post('/loadsptype','SettingController@loadsptype');

	//spare part type group
	route::get('/spgmaster', 'SettingController@spgmaster');
	route::get('/cekspg', 'SettingController@cekspg');
	route::post('/createspg', 'SettingController@createspg');
	route::post('/editspg', 'SettingController@editspg');
	route::post('/deletespg', 'SettingController@deletespg');
	route::get('/spgsearch', 'SettingController@spgsearch');
	route::get('/spgmaster/pagination', 'SettingController@spgpagination');
	route::post('/loadspgroup', 'SettingController@loadspgroup');

	//spare part master
	route::get('/spmmaster', 'SettingController@spmmaster');
	route::get('/cekspm', 'SettingController@cekspm');
	route::post('/createspm', 'SettingController@createspm');
	route::post('/editspm', 'SettingController@editspm');
	route::post('/deletespm', 'SettingController@deletespm');
	route::get('/spmsearch', 'SettingController@spmsearch');
	route::get('/spmmaster/pagination', 'SettingController@spmpagination');
	Route::post('/loadsparepart', 'SettingController@loadsparepart');

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
	route::get('/viewum', 'SettingController@viewum');
	route::post('/createins', 'SettingController@createins');
	route::post('/editins', 'SettingController@editins');
	route::post('/deleteins', 'SettingController@deleteins');
	route::get('/inssearch', 'SettingController@inssearch');
	route::get('/insmaster/pagination', 'SettingController@inspagination');
	route::get('/addpart', 'SettingController@addpart');
	route::post('/saveaddpart', 'SettingController@saveaddpart');

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
	route::get('/searchlocsp', 'SettingController@searchlocsp');
	route::get('/searchlocsp2', 'SettingController@searchlocsp2');
	
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

	//Qxwsa Master
	Route::resource('qxwsa', QxWsaMTController::class);

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
	route::get('/prevsch', 'UserChartController@prevsch');
	route::get('/needsp', 'UserChartController@needsp');

	//work order maintenance
	Route::get('/womaint', [wocontroller::class, 'womaint'])->name('womaint');
	Route::post('/createwo', [wocontroller::class, 'createwo']);
	Route::get('/searchic', [wocontroller::class, 'searchic']);
	Route::get('/filtermaintcode', [wocontroller::class, 'filtermaintcode']);
	// route::get('/womaint/pagination', 'wocontroller@wopaging');
	route::post('/editwo', [wocontroller::class, 'editwo']); 
	route::post('/editwoeng','wocontroller@editwoeng'); 
	route::post('/closewo',[wocontroller::class, 'closewo']); 
	route::get('/womaint/getnowo','wocontroller@geteditwoold');
	route::get('/womaint/getwoinfo',[wocontroller::class, 'geteditwo'])->name('editWO');
	route::get('/womaint/getfailure','wocontroller@getfailure');
	route::get('/openprint/{wo}','wocontroller@openprint');
	route::get('/openprint2/{wo}','wocontroller@openprint2');
	route::get('/wodownloadfile/{wo}','wocontroller@downloadfile');
	route::get('/wobrowseopen', 'wocontroller@wobrowseopen'); //tyas, link dari Home 
	route::get('/imageview_womaint', [wocontroller::class, 'imageview_womaint']);
	route::get('/delfilewomaint/{id}', [wocontroller::class, 'delfilewomaint']);
	route::get('/downloadwomaint/{id}', [wocontroller::class, 'downloadwomaint']);
	route::get('/imageviewonly_woimaint', [wocontroller::class, 'imageviewonly_woimaint']);
	//work order start
	route::get('/wojoblist', 'wocontroller@wojoblist')->name('wojoblist');
	route::get('/viewwosparepart/{wonumber}', [wocontroller::class, 'viewsp'])->name('viewSP');
	route::post('/editjob', 'wocontroller@editjob');
	route::get('/wojoblist/pagination', 'wocontroller@wopagingstart');

	//wo approval
	route::get('/routewo','wocontroller@routewo');
	route::get('/woapprovalbrowse','wocontroller@woapprovalbrowse')->name('woapprovalbrowse'); 
	route::get('/woapprovalbrowse/pagination','wocontroller@woapprovalpaging')->name('woapprovalpaging'); 
	route::post('/approvewo','wocontroller@approvewo'); 
	route::get('/woapprovaldetail/{wonumber}', [wocontroller::class, 'woapprovaldetail'])->name('approvalWO');
	route::get('/woapprovaldetail-info/{wonumber}', [wocontroller::class, 'woapprovaldetailinfo'])->name('approvalWOInfo');

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
	route::get('/woreport/reissued/{wo}',[wocontroller::class, 'reissued_wo'])->name('reissuedWO');
	route::post('/reissuedwofinish', [wocontroller::class, 'reissuedwofinish']);
	route::get('/woreportingdetail/{wonumber}', [wocontroller::class, 'woreportingdetail'])->name('reportingWO');


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
	route::get('/srapprovaleng', 'ServiceController@srapprovaleng');
	route::get('/engineersearch','ServiceController@engajax');
	route::post('/approval', 'ServiceController@approval');
	route::post('/approvaleng', 'ServiceController@approvaleng');
	route::get('/srapproval/searchapproval', 'ServiceController@searchapproval');
	route::get('/srapproval/searchapprovaleng', 'ServiceController@searchapprovaleng');
	route::get('/searchimpactdesc', 'ServiceController@searchimpact');
	route::get('/searchfailtype','ServiceController@searchfailtype');
	route::get('/searchfailcode','ServiceController@searchfailcode');
	route::get('/srcheckfailurecodetype','ServiceController@srcheckfailurecodetype');
	route::get('/routesr','ServiceController@routesr');
	route::get('/routesreng','ServiceController@routesreng');
	route::post('/cancelsr','ServiceController@cancelsr');


	//bagian tommy sr browse
	route::get('/srbrowse', 'ServiceController@srbrowse');
	route::get('/srbrowse/searchsr', 'ServiceController@searchsr');
	route::get('/srbrowseopen', 'ServiceController@srbrowseopen'); //tyas, link dari Home
	route::get('/donlodsr','ServiceController@donlodsr'); //tyas, excel SR
	route::get('/useracceptance', 'ServiceController@useracceptance'); 
	route::post('/acceptance', 'ServiceController@acceptance');
	route::get('/useracceptance/search', 'ServiceController@searchuseracc');
	route::get('/downloadfile/{id}', 'ServiceController@downloadfile');
	route::get('/listupload/{id}', 'ServiceController@listupload')->name('listupload');
	route::get('/listuploadview/{id}', 'ServiceController@listuploadview')->name('listuploadview');
	route::get('/srdownloadfile/{sr}','ServiceController@downloadfilezip');
	route::get('/srprint/{sr}','ServiceController@srprint');
	route::post('/editsr','ServiceController@editsr'); 
	route::get('/deleteuploadsr/{id}', 'ServiceController@deleteuploadsr');

	// Setting
	route::get('/runningmstr', 'SettingController@runningmstr');
	route::post('/updaterunning', 'SettingController@updaterunning');
	route::get('/picklogic', 'SettingController@picklogic');
	route::post('/picksave', 'SettingController@picksave');
	
	//image tommy
	route::get('/imageview', 'ServiceController@imageview');

	// 27.07.2021 booking tyas
	route::get('/booking', 'BookingController@booking')->name('bookingBrowse');
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

	// wo release
	Route::get('/worelease', [WORelease::class, 'browse'])->name('browseRelease');
	Route::get('/worelease/releasedetail/{id}', [WORelease::class, 'detailrelease'])->name('ReleaseDetail');
	Route::post('/worelease/requestwh', [WORelease::class, 'requesttowh'])->name('requestWH');
	Route::post('/submitrelease', [WORelease::class,'submitrelease'])->name('submitRelease');

	// wo confirm engineer
	Route::get('/confeng', [ConfirmEng::class, 'index'])->name('browseConfEng');
	Route::get('/confeng/confirmdetail/{id}', [ConfirmEng::class, 'detailconfirm'])->name('ConfDetail');
	Route::post('/engsubmit', [ConfirmEng::class,'engsubmit'])->name('EngconfSubmit');

	// WHS Confirm
	Route::get('/wotransfer', [WHSConfirm::class, 'browse'])->name('browseWhconfirm');
	Route::post('/search', [WHSConfirm::class, 'searchWO'])->name('search');
	Route::get('/wotransfer/detailwhs/{id}', [WHSConfirm::class, 'detailwhs'])->name('WhsconfDetail');
	Route::post('/whssubmit', [WHSConfirm::class,'whssubmit'])->name('WhsconfSubmit');
	Route::get('/searchlot', [WHSConfirm::class, 'searchlot'])->name('searchlot');
	Route::get('/getwsastockfrom', [WHSConfirm::class, 'getwsastockfrom']);
	
	//Generate WO PM
	Route::get('/viewwogenerator', [AllWOGenerate::class, 'viewWoGenerator'])->name('viewWOGen');
	Route::post('/wogenerator', [AllWOGenerate::class, 'getAll'])->name('indexWoGenerate');

	// List Spare part
	Route::get('/kebutuhansp', [KebutuhanSPController::class, 'index'])->name('browseKsp');
	Route::post('/needsp/generateso', [UserChartController::class, 'generateso'])->name('generateSO');

	// Detail WO Report
	Route::get('/rptdetwo', [RptDetWOController::class, 'index'])->name('browseDetailWO');
	Route::get('/exceldetwo', [RptDetWOController::class, 'index'])->name('excelDetailWO');
	
	Route::get('/rptcost', [RptCostController::class, 'index'])->name('rptcost');
	Route::get('/rptcostview', [RptCostController::class, 'rptcostview'])->name('rptcostview');
	// Route::get('/yearcost', [RptCostController::class, 'yearcost'])->name('yearcost');
	

	// Asset Site
	Route::get('/assetsite', [AssetSiteController::class, 'index']);
	Route::post('/createaassetsite', [AssetSiteController::class, 'store']);
	Route::post('/editassetsite', [AssetSiteController::class, 'edit']);
	Route::post('/deleteassetsite', [AssetSiteController::class, 'destroy']);

	// Asset Location
	Route::get('/assetloc', [AssetLocController::class, 'index']);
	Route::post('/createaassetloc', [AssetLocController::class, 'store']);
	Route::post('/editassetloc', [AssetLocController::class, 'update']);
	Route::post('/deleteassetloc', [AssetLocController::class, 'destroy']);

	// Asset Movement
	Route::get('/assetmove', [AssetMoveController::class, 'index']);
	Route::post('/createaassetmove', [AssetMoveController::class, 'store']);
	Route::post('/editassetmove', [AssetMoveController::class, 'update']);
	Route::post('/deleteassetmove', [AssetMoveController::class, 'destroy']);
	route::get('/cekassetloc', [AssetMoveController::class, 'cekassetloc']);

	// PM Detail per Asset
	Route::get('/pmdets', [PMdetsController::class, 'index'])->name('pmdets');
	Route::get('/newpmdets', [PMdetsController::class, 'create'])->name('newpmdets');
	Route::post('/createapmdets', [PMdetsController::class, 'store']);
	Route::post('/editpmdets', [PMdetsController::class, 'update']);
	Route::post('/deletepmdets', [PMdetsController::class, 'destroy']);

	//work order approval qc
	Route::get('woqc', [WoQcController::class,'index'])->name('woQCIndex');
	Route::post('woqc/update',[WoQcController::class,'update'])->name('woQCUpdate');
	Route::get('woqc/{id}/{nbr}', [WoQcController::class, 'show'])->name('woQCDetail');

	// Report Remaining Sparepart
	Route::get('remsp', [RemainSpController::class, 'index']);

	// Menentukan Engineer untuk PM
	Route::get('pmeng', [PmEngController::class, 'index'])->name('pmeng');
	Route::post('createapmeng', [PmEngController::class, 'store']);
	Route::post('editpmeng', [PmEngController::class, 'update']);
	Route::post('deletepmeng', [PmEngController::class, 'destroy']);
	Route::get('searcheng', [PmEngController::class, 'searcheng']);

	// Report Schedule Asset Year
	Route::get('assetyear', [RptAssetYearController::class, 'index']);

	// Master UM
	Route::get('/um', [UMController::class, 'index']);
	Route::get('/cekum', [UMController::class, 'cekum']);
	Route::post('/createum', [UMController::class, 'store']);
	Route::post('/editum', [UMController::class, 'update']);
	Route::post('/deleteum', [UMController::class, 'destroy']);

	// Usage Browse untuk melihat data measurement asset yang tipe perhitungan Meter yang telah diinput
	Route::get('/usbrowse', [UsageBrowseController::class, 'index'])->name('usbrowse');

	// Asset - Failure
	Route::get('/asfn', [AsfnController::class, 'index']);
	Route::post('/createaasfn', [AsfnController::class, 'store']);
	Route::post('/editasfn', [AsfnController::class, 'update']);
	Route::post('/deleteasfn', [AsfnController::class, 'destroy']);
	Route::get('/cekasfn', [AsfnController::class, 'cekasfn']);
	Route::get('/editdetailasfn', [AsfnController::class, 'editdetailasfn']);

	//Return Back Spare Part
	Route::get('/returnbacksp', [wocontroller::class, 'returnsp'])->name('returnSPBrowse');
	Route::get('/retrunbacksp/detail/{wonbr}', [wocontroller::class, 'returnsp_detail'])->name('RBDetail');
	Route::post('/returnbacksp/submitdata', [wocontroller::class, 'submit_returnback']);

	//cek failure code dan failure type
	Route::get('/checkfailurecodetype',[wocontroller::class, 'checkfailurecodetype']);

	// Engineer Group
	Route::get('/enggroup',[EngGroupContoller::class, 'index']);
	Route::post('/createegr', [EngGroupContoller::class, 'store']);
	Route::get('/editdetegr', [EngGroupContoller::class, 'editdetegr']);
	Route::post('/editegr', [EngGroupContoller::class, 'update']);
	Route::post('/deleteegr', [EngGroupContoller::class, 'destroy']);

	// Instruction List
	Route::get('/inslist',[InsListController::class, 'index']);
	Route::get('/cekinslist',[InsListController::class, 'cekinslist']);
	Route::post('/createinslist',[InsListController::class, 'store']);
	Route::get('/editdetins',[InsListController::class, 'editdetins']);
	Route::post('/editinslist',[InsListController::class, 'update']);
	Route::post('/delinslist', [InsListController::class, 'destroy']);
	
	// Sparepart List
	Route::get('/splist',[SplistController::class, 'index']);
	Route::get('/getspmstr',[SplistController::class, 'getspmstr'])->name('getspmstr');
	Route::get('/cekspglist',[SplistController::class, 'cekspglist']);
	Route::post('/createsplist',[SplistController::class, 'store']);
	Route::get('/editdetsplist',[SplistController::class, 'editdetsplist']);
	Route::post('/editsplist',[SplistController::class, 'update']);
	Route::post('/delsplist', [SplistController::class, 'destroy']);

	// PM Code Maintenance
	Route::get('/pmcode',[PMCodeController::class, 'index']);
	Route::get('/cekpmclist',[PMCodeController::class, 'cekpmclist']);
	Route::post('/createpmcode',[PMCodeController::class, 'store']);
	Route::post('/editpmcode',[PMCodeController::class, 'update']);
	Route::post('/delpmcode', [PMCodeController::class, 'destroy']);

	// QC Spec
	Route::get('/qcspec',[QCSpecController::class, 'index']);
	Route::get('/cekqcslist',[QCSpecController::class, 'cekqcslist']);
	Route::post('/createqcs',[QCSpecController::class, 'store']);
	Route::get('/editdetqcs', [QCSpecController::class, 'editdetqcs']);
	Route::post('/editqcs',[QCSpecController::class, 'update']);
	Route::post('/delqcs', [QCSpecController::class, 'destroy']);

	//Preventive Maintenance
	Route::get('/pmasset',[PmassetController::class, 'index']);
	route::get('/cekpmmtc', [PmassetController::class, 'cekpmmtc']);
	Route::get('/pickeng',[PmassetController::class, 'pickeng']);
	Route::post('/creatpmasset',[PmassetController::class, 'store']);
	Route::post('/editpmasset',[PmassetController::class, 'update']);
	Route::post('/delpmasset', [PmassetController::class, 'destroy']);

	//Routine Check Maintenance
	Route::get('/rcmmstr',[RcmMstrController::class, 'index']);
	Route::get('/cekrcmlist',[RcmMstrController::class, 'cekrcmlist']);
	Route::post('/creatrcmmstr',[RcmMstrController::class, 'store']);
	Route::post('/editrcmmstr',[RcmMstrController::class, 'update']);
	Route::post('/delrcmmstr', [RcmMstrController::class, 'destroy']);

	//Approval SR Maintenance
	Route::get('/appsr',[AppSrController::class, 'index']);
	Route::get('/editdetappsr',[AppSrController::class, 'editdetappsr']);
	Route::post('/editappsr',[AppSrController::class, 'update']);
	Route::post('/delappsr', [AppSrController::class, 'destroy']);

	//Approval WO Maintenance
	Route::get('/appwo',[AppWoController::class, 'index']);
	Route::get('/getApp',[AppWoController::class, 'getApp']);
	Route::post('/createappwo',[AppWoController::class, 'update']);

	//Inventory Source Maintenance
	Route::get('/invso',[InvSoController::class, 'index']);
	Route::get('/locsp',[InvSoController::class, 'locsp']);
	Route::get('/locsp2',[InvSoController::class, 'locsp2']);
	Route::get('/cekinvso',[InvSoController::class, 'cekinvso']);
	Route::post('/createinvso',[InvSoController::class, 'store']);
	Route::get('/editdetinvso',[InvSoController::class, 'editdetinvso']);
	Route::post('/editinvso',[InvSoController::class, 'update']);
	Route::post('/delinvso', [InvSoController::class, 'destroy']);

	//Inventory Supply Maintenance
	Route::get('/invsu',[InvSuController::class, 'index']);
	Route::post('/createinvsu',[InvSuController::class, 'store']);
	Route::get('/editdetinvsu',[InvSuController::class, 'editdetinvsu']);
	Route::post('/editinvsu',[InvSuController::class, 'update']);
	Route::post('/delinvsu', [InvSuController::class, 'destroy']);

	// 5 Why Transaction
	Route::get('/whyhist',[WhyHistController::class, 'index']); 
	Route::get('/searchwoasset',[WhyHistController::class, 'searchwoasset']); 
	Route::post('/createwhyhist',[WhyHistController::class, 'store']);
	route::get('/whyfile/{id}', [WhyHistController::class, 'whyfile'])->name('whyfile');
	Route::post('/editwhyhist',[WhyHistController::class, 'update']);
	Route::post('/delwhyhist', [WhyHistController::class, 'destroy']);

	//tambahan reporting WO
	Route::get('/getwsasupply', [wocontroller::class, 'getwsasupply']);
	Route::get('/getwodetsp', [wocontroller::class, 'getwodetsp']);
	
	//Request Sparepart
	Route::get('/reqsp', [SparepartController::class, 'reqspbrowse'])->name('reqspbrowse');
	Route::get('/reqspcreate', [SparepartController::class, 'reqspcreate'])->name('reqspcreate');
	Route::post('/reqspsubmit', [SparepartController::class,'reqspsubmit'])->name('reqspsubmit');
	Route::get('/reqspeditdet',[SparepartController::class, 'reqspeditdet']);
	Route::get('/reqspviewdet',[SparepartController::class, 'reqspviewdet']);
	Route::post('/reqspupdate',[SparepartController::class, 'reqspupdate']);
	Route::post('/reqspcancel', [SparepartController::class, 'reqspcancel']);

	//Transfer Sparepart
	Route::get('/trfsp', [SparepartController::class, 'trfspbrowse'])->name('trfspbrowse');
	Route::get('/trfspdet/{id}', [SparepartController::class, 'trfspdet'])->name('trfspdet');
	Route::post('/trfspsubmit', [SparepartController::class,'trfspsubmit'])->name('trfspsubmit');
	Route::get('/gettrfspwsastockfrom', [SparepartController::class, 'gettrfspwsastockfrom']);
	Route::get('/trfspviewdet', [SparepartController::class, 'trfspviewdet']);
	
	// PM Confirm
	Route::get('/pmconf',[PmConfirmController::class, 'index'])->name('pmconf'); 
	Route::get('/searchlog',[PmConfirmController::class, 'searchlog']); 
	Route::get('/getdetpmco',[PmConfirmController::class, 'getdetpmco']); 
	Route::post('/pmtoconf',[PmConfirmController::class, 'update']); 

	// PM Notif Message
	Route::get('/pmmssg',[PmmssgController::class, 'index'])->name('pmmssg'); 
	Route::post('/chgdatewo',[PmmssgController::class, 'chgdatewo']); 

	// Master Notifikasi
	Route::get('/notmssg',[NotmssgController::class, 'index']); 
	Route::post('/createmsg',[NotmssgController::class, 'store']);
	
	//akumulatif spare part transfer menu
	Route::get('/accutransfer', [SparepartController::class, 'accutransfer'])->name('accuTransBrw');
	Route::get('/searchaccutrf', [SparepartController::class, 'searchaccutrf']);
	Route::post('/submitaccutrf', [SparepartController::class, 'submitaccutrf']);

	//my routine check browse
	Route::get('/myroutine', [RoutineCheckController::class, 'myroutinebrowse'])->name('myroutine');
	Route::get('/myroutine/detail/{id}', [RoutineCheckController::class, 'routincheckdetail'])->name('myrcdetail');
	Route::post('/myroutinesubmit', [RoutineCheckController::class, 'routinesubmit'])->name('routinesubmit');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');