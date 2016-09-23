<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Stylist.php";
    require_once __DIR__."/../src/Client.php";

    date_default_timezone_set('America/Los_Angeles');

    use Symfony\Component\Debug\Debug;
    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    Debug::enable();

    $app = new Silex\Application();

    $app['debug'] = true;

    // //ALTERNATIVE SERVER:
    $server = 'mysql:host=localhost;dbname=hair_salon';
    // $server = 'mysql:host=localhost:8889;dbname=hair_salon';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
        $stylists = Stylist::getAll();
        return $app['twig']->render('index.html.twig', array('stylists' => $stylists));
    });

    $app->post("/", function() use ($app) {
        $new_stylist = new Stylist($id = null, $_POST['name']);
        $new_stylist->save();
        $stylists = Stylist::getAll();
        return $app['twig']->render('index.html.twig', array('stylists' => $stylists));
    });

    $app->post("/delete_all", function() use ($app) {
        Stylist::deleteAll();
        $stylists = Stylist::getAll();
        return $app['twig']->render('index.html.twig', array('stylists' => $stylists));
    });

    $app->get("/stylist/{id}", function($id) use ($app) {
        $stylist = Stylist::find($id);
        $clients = $stylist->findClients();
        $stylists = Stylist::getAll();
        return $app['twig']->render('stylist.html.twig', array ('stylist' => $stylist, 'clients' => $clients));
    });

    $app->post("/stylist/{id}/", function($id) use ($app) {
        $stylist = Stylist::find($id);
        $new_client = new Client($id = null, $_POST['client_name'], $_POST['stylist_id']);
        $new_client->save();
        $clients = $stylist->findClients();
        $stylists = Stylist::getAll();
        return $app['twig']->render('stylist.html.twig', array ('stylist' => $stylist, 'clients' => $clients));
    });

    $app->post("/stylist/{id}/delete_all", function($id) use ($app) {
        $stylist = Stylist::find($id);
        $stylist->deleteClients();
        $clients = $stylist->findClients();
        $stylists = Stylist::getAll();
        return $app['twig']->render('stylist.html.twig', array ('stylist' => $stylist, 'clients' => $clients));
    });

    $app->get("/stylist/{id}/edit", function($id) use ($app) {
        $stylist = Stylist::find($id);
        $stylists = Stylist::getAll();
        return $app['twig']->render('stylist_edit.html.twig', array ('stylist' => $stylist));
    });

    $app->patch("/stylist/{id}/edit", function($id) use ($app) {
        $stylist = Stylist::find($id);
        $editted_stylist = $stylist->updateStylist($_POST['stylist_name']);
        $clients = $stylist->findClients();
        $stylists = Stylist::getAll();
        return $app['twig']->render('stylist.html.twig', array ('stylist' => $stylist, 'clients' => $clients));
    });

    $app->get("/client/{id}/", function($id) use ($app) {
        $client = Client::find($id);
        return $app['twig']->render('client_edit.html.twig', array ('client' => $client));
    });

    $app->patch("/client/{id}/edit", function($id) use ($app) {
        $edit_client = Client::find($id);
        $stylist_id = $edit_client->getStylistId();
        $edit_client->updateClient($_POST['client_name']);
        $stylist = Stylist::find($stylist_id);
        $clients = $stylist->findClients();
        $stylists = Stylist::getAll();
        return $app['twig']->render('stylist.html.twig', array ('stylist' => $stylist, 'clients' => $clients));
    });







    return $app;
?>
