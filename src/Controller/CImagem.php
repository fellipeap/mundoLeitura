<?php
namespace mundoleitura\Controller;
use Symfony\Component\HttpFoundation\Response;
use mundoleitura\Model\Imagem;
use Twig\Environment;


class CImagem
{

    private $resposta;
    private $twig;

    public function __construct(Response $resposta, Environment $twig)
    {
        $this->resposta = $resposta;
        $this->twig = $twig;
    }

    public function uploadImg($categoria)
    {
        $up = new Imagem();
       
       if ($up->uploadImagem($categoria)) { 
            echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Upload efetuado com sucesso!')
            window.history.back();
        </SCRIPT>");
        } else {
            echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Erro ao fazer o upload da imagem.')
            window.history.back();
        </SCRIPT>");
        }
    }

    public function removerImg($idImg){

        $rm = new Imagem();

    }
}