<?php
namespace mundoleitura\Controller;

use mundoleitura\Model\Livro;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class Home
{
    private $resposta;
    private $twig;

    public function __construct(Response $resposta, Environment $twig)
    {
        $this->resposta = $resposta;
        $this->twig = $twig;
    }

    public function index()
    {

       $cabecalho = new Livro();
       $categorias = $cabecalho->categorias();

      foreach($categorias as $c){
          $livros[$c['categorias']] = $cabecalho-> livrosCadastrados($c['categorias']);
       }
              
       $valores = [
            'titulo' => 'Mundo leitura',
            'categorias' => $categorias,
            'livros' =>  $livros
       ];
   //   echo '<pre>'.print_r($valores, true).'</pre>';

        $template = $this->twig->load('home.html');
        $this->resposta->setContent($template->render($valores));
    }

    

}