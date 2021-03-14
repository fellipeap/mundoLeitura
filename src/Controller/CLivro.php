<?php

namespace mundoleitura\Controller;

use mundoleitura\Model\Livro;
use mundoleitura\Model\Imagem;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class CLivro
{

  private $teste = "teste";
  private $resposta;
  private $twig;

  public function __construct(Response $resposta, Environment $twig)
  {
    $this->resposta = $resposta;
    $this->twig = $twig;
  }

  public function renderCadastraLivros()
  {

    $img = new Imagem();
    $livro = new Livro();
    $valores = [
      'titulo' => 'Cadastro de Livros',
      'categorias' => $livro->categorias(),
      'imgLivre' => $img->imgDisponiveis('L'),
      'tipoImg' => 'L' //tipo de imagem para fazer upload
    ];
    //  echo '<pre>' . print_r($valores, true) . '</pre>';
    $template = $this->twig->load('cadastroLivro.html');
    $this->resposta->setContent($template->render($valores));
  }

  public function salvarLivro()
  {

    $livro = [
      'titulo' => $_REQUEST['titulo'],
      'autor' => $_REQUEST['autor'],
      'editora' => $_REQUEST['editora'],
      'dataPublicacao' => $_REQUEST['data_publicacao'],
      'categoria' => $_REQUEST['categoria'],
      'historia' => $_REQUEST['historia'],
      'premium' => $_REQUEST['premium'],
      'idImg' => $_REQUEST['id_img'],
    ];
    //  echo '<pre>' . print_r($livro, true) . '</pre>';

    if (
      empty($livro['titulo']) || empty($livro['categoria']) ||
      empty($livro['historia']) || empty($livro['premium']) ||
      empty($livro['idImg'])
    ) {
      echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Os campos marcados com * são obrigatórios!')
        window.history.back();
    </SCRIPT>");
    }
      //verdadeiro retorna 0
      if (!strcmp($livro['premium'], 'Sim')) {
        $livro['premium'] = 1;
      } else {
        $livro['premium'] = 0;
      }
      echo '<pre>' . print_r($livro, true) . '</pre>';

    $newLivro = new Livro();

    if ($newLivro->salvarLivro($livro)) {
      echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Livro salvo com sucesso!')
        window.history.back();
    </SCRIPT>");
    } {
      echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Erro ao salvar os dados!')
        window.history.back();
    </SCRIPT>");
    }
  }

  public function renderVerLivro($idLivro) //ver livro
  {

    $dtLivro = new Livro();
    $aux = $dtLivro->detalhesLivro($idLivro);

 /*   if (empty($aux)) {
      echo ("<SCRIPT LANGUAGE='JavaScript'>
      window.alert('Este item possui campo obrigatório não preechido.\\n Acesse Editar para corrigir.')
      window.history.back();
  </SCRIPT>");
      return;
    }*/
    if ($aux[0]['premium'] == 1) {
      $aux[0]['premium'] = "Sim";
    } else {
      $aux[0]['premium'] = "Não";
    }

    $valores = [
      'id_livro' => $idLivro,
      'titulo' => 'Detalhes da publicação',
      'texto' => $aux[0]['texto'],
      'tituloLivro' => $aux[0]['titulo'],
      'nome_extensao' => $aux[0]['nome_extensao'],
      'categoria' => $aux[0]['categoria'],
      'premium' => $aux[0]['premium'],
      'datapublicacao' => $aux[0]['datapublicacao'],
      'autor' => $aux[0]['autor'],
      'editora' => $aux[0]['editora'],
      'update' => $aux[0]['updated_time']
    ];

    //   echo '<pre>'.print_r($valores, true).'</pre>';
    $template = $this->twig->load('verLivro.html');
    $this->resposta->setContent($template->render($valores));
  }


  public function renderEditarLivro($idLivro)
  {

    $img = new Imagem();
    $dtLivro = new Livro();
    $aux = $dtLivro->selectEditaLivro($idLivro);

    if ($aux[0]['premium'] == 1) {
      $aux[0]['premium'] = "Sim";
    } else {
      $aux[0]['premium'] = "Não";
    }

    $livro = [
      'idLivro' => $idLivro,
      'texto' => $aux[0]['texto'],
      'tituloLivro' => $aux[0]['titulo'],
      'nome_extensao' => $aux[0]['nome_extensao'],
      'categoria' => $aux[0]['categoria'],
      'premium' => $aux[0]['premium'],
      'datapublicacao' => $aux[0]['datapublicacao'],
      'autor' => $aux[0]['autor'],
      'editora' => $aux[0]['editora'],
      'id_img' => $aux[0]['idImg']
    ];

    $valores = [
      'titulo' => 'Editar Livro',
      'categorias' => $dtLivro->categorias(),
      'imgLivre' => $img->imgDisponiveis('L'),
      'livro' => $livro,
      'tipoImg' => 'L'
    ];
    //   echo '<pre>'.print_r($valores, true).'</pre>';
    $template = $this->twig->load('editaLivro.html');
    $this->resposta->setContent($template->render($valores));
  }

  public function setLivro($idLivro) //Altera os dados
  {
    $livro = [
      'idLivro' => $idLivro,
      'titulo' => $_REQUEST['titulo'],
      'autor' => $_REQUEST['autor'],
      'editora' => $_REQUEST['editora'],
      'dataPublicacao' => $_REQUEST['data_publicacao'],
      'categoria' => $_REQUEST['categoria'],
      'historia' => $_REQUEST['historia'],
      'premium' => $_REQUEST['premium'],
      'idImg' => $_REQUEST['id_img'],
    ];

    echo '<pre>' . print_r($livro, true) . '</pre>';

    if (
      empty($livro['titulo']) || empty($livro['categoria']) ||
      empty($livro['historia']) || empty($livro['premium']) ||
      empty($livro['idImg'])
    ) {
      /*  echo ("<SCRIPT LANGUAGE='JavaScript'>
      window.alert('Os campos marcados com * são obrigatórios!')
      window.history.back();
      </SCRIPT>");*/
      return;
    }
    //verdadeiro retorna 0
    if (!strcmp($livro['premium'], 'Sim')) {
      $livro['premium'] = 1;
    } else {
      $livro['premium'] = 0;
    }
    $upLivro = new Livro();

    if ($upLivro->updateEditaLivro($livro)) {
      echo ("<SCRIPT LANGUAGE='JavaScript'>
      window.alert('Atualizado com sucesso!')
      window.history.back();
  </SCRIPT>");
    } else {
      echo ("<SCRIPT LANGUAGE='JavaScript'>
      window.alert('Falha ao atualizar!')
      window.history.back();
  </SCRIPT>");
    }
  }

  public function renderExcluirLivro(){

    $cabecalho = new Livro();
    $categorias = $cabecalho->categorias();

   foreach($categorias as $c){
       $livros[$c['categorias']] = $cabecalho-> livrosCadastrados($c['categorias']);
    }
           
    $valores = [
         'titulo' => 'Exluir livro',
         'categorias' => $categorias,
         'livros' =>  $livros
    ];
//   echo '<pre>'.print_r($valores, true).'</pre>';
     $template = $this->twig->load('excluirLivro.html');
     $this->resposta->setContent($template->render($valores));
 
  }

  public function deleteLivro(){

    
  }


}
