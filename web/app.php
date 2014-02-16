<?php

// Composer autoload
require_once __DIR__.'/../vendor/autoload.php';

// Importations
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\SwiftmailerServiceProvider;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\Yaml\Yaml;

// Instance de Silex
$app = new Application();

// Config
$app['config'] = Yaml::parse(file_get_contents(__DIR__ . '/../config/parameters.yml'));
$app['routing'] = Yaml::parse(file_get_contents(__DIR__ . '/../config/routing.yml'));
$app['seo'] = Yaml::parse(file_get_contents(__DIR__ . '/../config/seo.yml'));

// Debug
$app['debug'] = $app['config']['parameters']['debug'];

// Registering
$app->register(new UrlGeneratorServiceProvider());
$app->register(new FormServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new SwiftmailerServiceProvider());
$app->register(new TranslationServiceProvider(), array(
    'locale' => $app['config']['parameters']['locale'],
    'locale_fallbacks' => array($app['config']['parameters']['locale']),
));
$app->register(new TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../templates',
    'twig.options' => array('cache' => __DIR__ . '/../var/cache'),
));

// Swiftmailer options
$app['swiftmailer.options'] = array(
    'host' => $app['config']['swiftmailer']['host'],
    'port' => $app['config']['swiftmailer']['port'],
    'username' => $app['config']['swiftmailer']['username'],
    'password' => $app['config']['swiftmailer']['password'],
    'encryption' => $app['config']['swiftmailer']['encryption'],
    'auth_mode' => $app['config']['swiftmailer']['auth_mode']
);

// Routes
foreach($app['routing'] as $name => $route) {
    $app->match($route['pattern'], $route['controller'])->bind($name)->method(isset($route['method'])?$route['method']:'GET');
}

// Erreurs
$app->error(function (\Exception $e, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    if ($code === 404) {
        return $app['twig']->render('404.html');
    } else {
        return new Response('We are sorry, but something went terribly wrong.', $code);
    }
});

// Run
$app->run();