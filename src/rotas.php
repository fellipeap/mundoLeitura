<?php

namespace mundoleitura;

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use mundoleitura\Controller\Home;
use mundoleitura\Controller\CLivro;
use mundoleitura\Controller\CImagem;



$routes = new RouteCollection();

$routes->add("Home", new Route('/', ["_controller" => Home::class, "_method" => "index"]));

$routes->add("RenderCadastraLivros", new Route('/clivro/cadastrar', [
    "_controller" => CLivro::class,
    "_method" => "renderCadastraLivros"
]));



/*É para que não de erro no <form>  o Syfony analisa 
todas as rotas e quando o form mandar a dele dará erro de rota não definida */
$routes->add("UploadImg", new Route('/img/upload/{parametro}', [
    "_controller" => CImagem::class,
    "_method" => "uploadImg"
]));


$routes->add("RemoveImg", new Route('/img/remover/{parametro}', [
    "_controller" => CImagem::class,
    "_method" => "removerImg"
]));

$routes->add("SalvaLivro", new Route('/clivro/salvar', [
    "_controller" => CLivro::class,
    "_method" => "salvarLivro"
]));

$routes->add("RenderVerLivro", new Route('/clivro/verlivro/{parametro}', [
    "_controller" => CLivro::class,
    "_method" => "renderVerLivro"
]));

$routes->add("RenderEditarLivro", new Route('/clivro/editarLivro/{parametro}', [
    "_controller" => CLivro::class,
    "_method" => "renderEditarLivro"
]));

$routes->add("SetLivro", new Route('/clivro/setLivro/{parametro}', [
    "_controller" => CLivro::class,
    "_method" => "setLivro"
]));

$routes->add("RenderExcluir", new Route('/clivro/excluirlivro', [
    "_controller" => CLivro::class,
    "_method" => "renderExcluirLivro"
]));

$routes->add("DeleteLivro", new Route('/clivro/deleteLivro', [
    "_controller" => CLivro::class,
    "_method" => "deleteLivro"
]));


///img/excluir

//echo '<pre>'.print_r($routes, true).'</pre>';
return $routes;
