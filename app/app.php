<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Stylist.php";
    date_default_timezone_set('America/Los_Angeles');

    use Symfony\Component\Debug\Debug;
    Debug::enable();

    $app = new Silex\Application();

    $app['debug'] = true;

    //ALTERNATIVE SERVER:
    //$server = 'mysql:host=localhost;dbname=hair_salon';
    $server = 'mysql:host=localhost:8889;dbname=hair_salon';
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

    return $app;
?>
