<?php
namespace mundoleitura\Model;

use mundoleitura\Util\Conexao;
use Exception;
use PDO;


class Imagem{

 public function _Construct(){}

 public function uploadImagem($tipo)
    {
        if (isset($_FILES['imagem'])) {
            $extensao = strtolower(substr($_FILES['imagem']['name'], -4)); //pega as 4 ultimas letras converte tudo para minusculo
            $novo_nome = md5(time()) . $extensao; //md5 irá fazer a criptográfia para q não aja arquivos duplicados e sobresrva o outro
            $diretorio = "img/";

            move_uploaded_file($_FILES['imagem']['tmp_name'], $diretorio . $novo_nome);

            $sql = "INSERT INTO imagem (id_cabe_img, tipo, nome_extensao) VALUES(:id_cabe_img, :tipo, :nome_extensao)";
            try {
                $p_sql = Conexao::getInstancia()->prepare($sql);
                $p_sql->bindValue(':id_cabe_img', -1); //imagem sem vinculo/nova
                $p_sql->bindValue(':tipo', $tipo);
                $p_sql->bindValue(':nome_extensao', $novo_nome);
                $p_sql->execute();
                return true;
            } catch (Exception $e) {
                echo '--'.$novo_nome;
                echo '--------UploadImagem | '.$e;
               // return false;
            }
        }
    }

    public function imgDisponiveis($tipo) //Imagens já disponíveis no servidor
    {
        try {

            $sql = "SELECT * FROM imagem WHERE tipo = '$tipo' AND id_cabe_img = -1";
            $p_sql = Conexao::getInstancia()->prepare($sql);
            $p_sql->execute();

            return $p_sql->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo 'imgDisponiveis | Ocorreu um erro ao mostrar as imagens do servidor....'.$e;
        }
    }

    public function removerImg($idImg){
        $diretorio = "img/";

        $sql = "SELECT imagem.nome_extensao FROM imagem WHERE id = '$idImg' ";
        $p_sql = Conexao::getInstancia()->prepare($sql);
        $p_sql->execute();

        $diretorio .$p_sql->fetchAll(PDO::FETCH_ASSOC);

        echo 'F removerImg';
        echo '<pre>'.print_r($diretorio, true).'</pre>';


        if(file_exists($diretorio)){
            unlink($diretorio);
        }else{
            
        }
    }
}