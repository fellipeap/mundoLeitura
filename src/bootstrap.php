<?php
namespace mundoleitura;

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use \Twig\Loader\FilesystemLoader;
use Twig\Environment;

require_once 'rotas.php';

$loader = new FilesystemLoader('../src/View/');
$twig = new Environment($loader);
$request = Request::createFromGlobals();

$resposta = new Response();
$context = new RequestContext('/');
$matcher = new UrlMatcher($routes, $context);

$parameters = $matcher->match($request->getPathInfo());
$controlador = $parameters['_controller'];

$objeto = new $controlador($resposta, $twig);

$metodo = $parameters['_method'];

 //  echo '<pre>'.print_r($metodo, true).'</pre>';

if (!strcmp($metodo, 'uploadImg') || !strcmp($metodo, 'removerImg')
|| !strcmp($metodo, 'renderVerLivro') || !strcmp($metodo, 'renderEditarLivro')
|| !strcmp($metodo, 'setLivro')) //return 0 se iguais
$objeto->$metodo($parameters['parametro']); //passando parametros
else
$objeto->$metodo(); //sem parametros

$resposta->send();