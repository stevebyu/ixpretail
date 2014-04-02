<?php

require 'vendor/autoload.php';


////// DATABASE //////
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection(array(
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'ixpdhl',
    'username'  => 'ixpdhl',
    'password'  => 'ixp45987',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
));

$capsule->bootEloquent();
$capsule->setAsGlobal();

///// SLIM //////

$app = new \Slim\Slim();

$app->add(new \Slim\Middleware\SessionCookie(array(
    'expires' => '20 minutes',
    'path' => '/',
    'domain' => null,
    'secure' => false,
    'httponly' => false,
    'name' => 'slim_session',
    'secret' => 'CHANGE_ME',
    'cipher' => MCRYPT_RIJNDAEL_256,
    'cipher_mode' => MCRYPT_MODE_CBC
)));

$app->config(array(
    'templates.path' => './ui',
));

$authenticate = function ($app) {
    return function () use ($app) {
        if (!isset($_SESSION['user'])) {
            //TODO: if AJAX, just return a 404...
           // $app->flash('error', 'Login required');
            $app->redirect('/login');
        }
    };
};

$app->get('/', $authenticate($app), function() use ($app) {
	$app->render('main.php');
});

$app->get('/login',function() use($app) {
    $app->render('login.php');
});

$app->post('/login', function() use ($app) {
    //TODO: CHECK CREDS...
    $vars = $app->request()->post();
    $user = User::
                    where('username', '=', $vars['username'])
                  ->where('password', '=', $vars['password'])
                  ->first();
    
    if (!isset($user)){
        $app->flash("error","Invalid Username or Password");
        $app->redirect("./login");
    }

    $_SESSION['user'] = $user;
    $app->redirect('./');
});

$app->get("/logout", function () use ($app) {
   unset($_SESSION['user']);
   $app->flash("message","Successfully logged out");
   $app->redirect("./login");
});



////PAGES//////

$app->get('/dashboard', $authenticate($app), function() use ($app) {
    $app->render('dashboard.php');
});

$app->get('/settings', $authenticate($app), function() use ($app) {
    $app->render('settings.php');
});

$app->get('/account', $authenticate($app), function() use ($app) {
     if ($_SESSION['user']['password_expired']){
        $app->flashNow('warning','Your password needs to be reset');
    }
    $app->render('account.php');
});

$app->get('/payment', $authenticate($app), function() use ($app) {
    $app->render('payment.php');
});


/////ADMIN/////

$app->get('/admin/dashboard', $authenticate($app), function() use ($app) {
    $app->render('admin/dashboard.php');
});

$app->get('/admin/manage', $authenticate($app), function() use ($app) {
    $app->render('admin/manage.php');
});

$app->get('/admin/report', $authenticate($app), function() use ($app) {
    $app->render('admin/report.php');
});

$app->get('/admin/communication', $authenticate($app), function() use ($app) {
    $app->render('admin/communication.php');
});

$app->get('/admin/users', $authenticate($app), function() use ($app) {
    $app->render('admin/users.php');
});

$app->get('/admin/stores', $authenticate($app), function() use ($app) {
    $app->render('admin/stores.php');
});

$app->get('/admin/reportsettings', $authenticate($app), function() use ($app) {
    $app->render('admin/reportsettings.php');
});


////API//////

$app->get('/api/users', $authenticate($app), function() use ($app) {
	$users = User::all();

    $res = $app->response();
    $res['Content-Type'] = 'application/json';
    $res->body($users);
});

$app->get('/api/users/:id', $authenticate($app), function($id) use ($app) {
	$users = User::with('store')->find($id);

    $res = $app->response();
    $res['Content-Type'] = 'application/json';
    $res->body($users);
});

$app->put('/api/users/:id', $authenticate($app), function($id) use ($app) {
    $data = $app->request->put();

    if ($_SESSION['user']['id'] != $id && $_SESSION['user']['admin'] != 1){
        return;
    }

    $user = User::find($id);

    foreach($data as $prop => $val){

        if ($prop == "password" && $_SESSION['user']['id'] != $id){
           continue;
        }

        $user[$prop] = $val;
    }
    $user->save();

    $res = $app->response();
    $res['Content-Type'] = 'application/json';
    $res->body($user);
});

$app->post('/api/users', $authenticate($app), function() use ($app) {
    $data = $app->request->post();
   
    if ($_SESSION['user']['admin'] != 1){
        return;
    }

    $user = User::firstOrNew(array("username"=>$data['username']));

    foreach($data as $prop => $val){

        if ($prop == "password"){
           continue;
        }

        $user[$prop] = $val;
    }
    $user->save();

    $res = $app->response();
    $res['Content-Type'] = 'application/json';
    $res->body($user);
});

$app->get('/api/stores', $authenticate($app), function() use ($app) {
	$stores = Store::all();

    $res = $app->response();
    $res['Content-Type'] = 'application/json';
    $res->body($stores);
});

$app->get('/api/stores/:id', $authenticate($app), function($id) use ($app) {
	$stores = Store::with('users')->find($id);

    $res = $app->response();
    $res['Content-Type'] = 'application/json';
    $res->body($stores);
});

$app->put('/api/stores/:id', $authenticate($app), function($id) use ($app) {
    $data = $app->request->put();

    if ($_SESSION['user']['admin'] != 1){
        return;
    }

    $store = Store::find($id);

    foreach($data as $prop => $val){

        $store[$prop] = $val;
    }
    $store->save();

    $res = $app->response();
    $res['Content-Type'] = 'application/json';
    $res->body($store);
});

$app->post('/api/stores', $authenticate($app), function() use ($app) {
    $data = $app->request->post();
   
    if ($_SESSION['user']['admin'] != 1){
        return;
    }

    $store = Store::create(array('name' => $data['name']));

    foreach($data as $prop => $val){

        if ($prop == "password"){
           continue;
        }

        $store[$prop] = $val;
    }
    $store->save();

    $res = $app->response();
    $res['Content-Type'] = 'application/json';
    $res->body($store);
});

$app->get('/api/notifications', $authenticate($app), function() use ($app){
    $req = $app->request();
    $days = $req->get('days');

    if (isset($days)){

        $start = date('Y-m-d H:m:s', strtotime("-{$days} days"));
        $notifications = Notification::where("updated_at", ">", $start);
    }
    else {
        $notifications = Notification::take(5)->get();
    }

    $res = $app->response();
    $res['Content-Type'] = 'application/json';
    $res->body($notification);
});

$app->get("/api/notifications/:id", $authenticate($app), function($id) use ($app){
    $notification = Notification::find($id);

    $res = $app->response();
    $res['Content-Type'] = 'application/json';
    $res->body($notification);
});

$app->post("/api/notifications", $authenticate($app), function() use ($app){
    $data = $app->request->post();


    if ($_SESSION['user']['admin'] == 1){
        $notification = Notification::create($data);
        $notification->save();

        $res = $app->response();
        $res['Content-Type'] = 'application/json';
        $res->body($notification);
    };
});

$app->put("/api/notifications/:id", $authenticate($app),function($id) use ($app){
    $data = $app->request->post();


    if ($_SESSION['user']['admin'] == 1){
        $notification = Count::create($data);
        $notification->save();

        $res = $app->response();
        $res['Content-Type'] = 'application/json';
        $res->body($notification);
    };
});

$app->get('/api/counts', $authenticate($app), function() use ($app) {

    $req = $app->request();
    $start = $req->get('start');
    $end = $req->get('end');
    $group = $req->get('group');

    if ( $_SESSION['user']['admin'] != 1 ){
        $counts = Count::getByStoreId($_SESSION['user']['store_id'], $start, $end);
    }
    else if (isset($group)){
        $counts = Count::getByRangeGrouped($start, $end, $group);
    }
    else {
        $counts = Count::getByRange($start, $end);
    }

    $res = $app->response();
    $res['Content-Type'] = 'application/json';
    $res->body($counts);
});

$app->get('/api/counts/:storeid', $authenticate($app), function($storeid) use ($app) {
    $req = $app->request();
    $start = $req->get('start');
    $end = $req->get('end');

    $counts = Count::getByStoreId($storeid, $start, $end);

    $res = $app->response();
    $res['Content-Type'] = 'application/json';
    $res->body($counts);
});

$app->post('/api/counts', $authenticate($app), function() use ($app) {
    $data = $app->request->post();
    $data['store_id'] = $_SESSION['user']['store_id'];

    $count = Count::firstOrNew(array(
                                        'date'=>$data['date'],
                                        'store_id'=>$_SESSION['user']['store_id']
                                        ));
    $count->count = $data['count'];
    $count->save();

    $res = $app->response();
    $res['Content-Type'] = 'application/json';
    $res->body($count);
});

$app->get('/api/report', $authenticate($app), function() use ($app){
    $req = $app->request();
    $start = $req->get('start');
    $end = $req->get('end');
    $format = $req->get('format');

    if ( $_SESSION['user']['admin'] != 1 ){
        return;
    }

    $reportData = Count::selectRaw("'R' as r,
                                    stores.name as store,
                                    '' as account,
                                    '' as routing,
                                    'InExpress' as franchise,
                                    '{$start} - {$end}' as period,
                                    '' as accounttype,
                                    sum(count) as pickups,
                                    sum(count)*1.5 as pay,
                                    '' as credit")
                                    ->where('date', "<=", $end)
                                    ->where('date', ">=", $start)
                                    ->join('stores', "store_id", "=", "stores.id")
                                    ->groupBy('store_id')
                                    ->get(array("stores.name","sum(count)"));


    $res = $app->response();

    if ($format == "csv"){

        $filename = "report{$start}-{$end}.csv";
        $f = fopen('php://output', 'w');

        foreach ($reportData->toArray() as $obj) {

            fputcsv($f, $obj, ",");
        }

        $res['Content-Type'] = 'application/csv';
        $res['Content-Disposition'] = "attachment; filename={$filename}";

        //$res->body($f);
    }
    else {
        $res['Content-Type'] = 'application/json';
        $res->body($reportData);
    }

    
});

$app->run();


?>
