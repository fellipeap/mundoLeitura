<?php
namespace mundoleitura\Model;

use mundoleitura\Util\Conexao;
use Exception;
use PDO;

class Livro
{

    public function __construct()
    {
    }
    function categorias(){
        $sql = " SELECT categorias FROM parametros";
        try{
            $p_sql = Conexao::getInstancia()->prepare($sql);
            $p_sql->execute();
            return $p_sql->fetchAll(PDO::FETCH_ASSOC);
        }catch (Exception $e) {
            echo '--------Ocorreu um erro ao listar as categorias ';
            print_r($e);
        }
    }
    function livrosCadastrados($categoria) //HOME
    {

        $sql = "SELECT c.id, c.titulo, c.categoria, c.autor, c.editora, date_format(c.updated_time, '%d/%m/%Y') AS data, 
        date_format(c.updated_time, '%h:%m') AS hora, i.nome_extensao FROM cabecalho AS c JOIN imagem as i 
        WHERE c.categoria = :categoria && i.id_cabe_img = c.id ORDER BY updated_time DESC";

        try {
            $p_sql = Conexao::getInstancia()->prepare($sql);
            $p_sql->bindValue(':categoria', $categoria);
            $p_sql->execute();
           return $p_sql->fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $e) {
            echo '--------Ocorreu um erro ao listar os livros cadastrados-> ' . $categoria . '<br>';
            print_r($e);
        }
    }

    public function salvarLivro($livro)
    {

        $sql = 'INSERT INTO cabecalho (titulo, categoria, autor, datapublicacao, editora, premium)
                VALUES (:titulo, UCASE(:categoria), :autor, :datapublicacao, :editora, :premium)';
        try {
            $p_sql = Conexao::getInstancia()->prepare($sql);
            $p_sql->bindValue(':titulo', $livro['titulo']);
            $p_sql->bindValue(':categoria', $livro['categoria']);
            $p_sql->bindValue(':autor', $livro['autor']);
            $p_sql->bindValue(':datapublicacao', $livro['dataPublicacao']);
            $p_sql->bindValue(':editora', $livro['editora']);
            $p_sql->bindValue(':premium', $livro['premium']);

            $p_sql->execute();
        } catch (Exception $e) {
            echo 'Cabeçalho---';
            print_r($e);
            return false;
        }

        try {
            $sql = 'SELECT max(id) as maxId from cabecalho';
            $p_sql = Conexao::getInstancia()->prepare($sql);
            $p_sql->execute();
            $id_cabe = $p_sql->fetch(PDO::FETCH_OBJ);

            $sql = 'UPDATE imagem SET id_cabe_img = ' . $id_cabe->maxId . ' WHERE id = ' . $livro['idImg'];
            $p_sql = Conexao::getInstancia()->prepare($sql);
            $p_sql->execute();
        } catch (Exception $e) {
            print_r($e);
            return false;
        }


        $sql = 'INSERT INTO texto_livro (id_cabecalho, texto)
        VALUES (:id_cabecalho, :texto)';

        try {
            $p_sql = Conexao::getInstancia()->prepare($sql);
            $p_sql->bindValue(':id_cabecalho', $id_cabe->maxId);
            $p_sql->bindValue(':texto', $livro['historia']);
            $p_sql->execute();

            return true;
        } catch (Exception $e) {
            echo 'historia---';
            print_r($e);
            return false;
        }
    }
    public function detalhesLivro($idLivro) // ver livro
    {
        $sql = " SELECT c.id, c.titulo, c.categoria, c.autor, 
            date_format( c.datapublicacao, '%d/%m/%Y') AS datapublicacao, 
            c.editora, c.premium, c.updated_time,
            i.nome_extensao, t.texto FROM cabecalho c 
            JOIN imagem i ON c.id = i.id_cabe_img 
            JOIN texto_livro t ON t.id_cabecalho = i.id_cabe_img where c.id = :idLivro";

        try {
            $p_sql = Conexao::getInstancia()->prepare($sql);
            $p_sql->bindValue(':idLivro', $idLivro);
            $p_sql->execute();

           return $p_sql->fetchAll(PDO::FETCH_ASSOC);

          /* $teste1 = $p_sql->fetchAll(PDO::FETCH_ASSOC);
           echo 'retorno comum';
           echo '<pre>'.print_r($teste1, true).'</pre>';
           echo '---------------------------------';
           //Retorna json com formatação/Acentuação
           $json = json_encode($teste1,JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
          */
        } catch (Exception $e) {
            echo 'DETALHES_LIVRO---';
            print_r($e);
            return false;
        }
    }

    public function selectEditaLivro($idLivro) //renderEditaLivro
    {

        $sql = " SELECT c.id, c.titulo, c.categoria, c.autor, 
            c.editora, c.premium,  c.datapublicacao,
            i.nome_extensao, i.id AS idImg, t.texto FROM cabecalho c 
            JOIN imagem i ON c.id = i.id_cabe_img 
            JOIN texto_livro t ON t.id_cabecalho = i.id_cabe_img where c.id = :idLivro";

        try {
            $p_sql = Conexao::getInstancia()->prepare($sql);
            $p_sql->bindValue(':idLivro', $idLivro);
            $p_sql->execute();

            return $p_sql->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo 'DETALHES_LIVRO---';
            print_r($e);
            return false;
        }
    }

    public function updateEditaLivro($livro)//Atualiza dados
    {
        $sql = "UPDATE cabecalho c JOIN imagem i ON c.id = i.id_cabe_img 
        JOIN texto_livro t ON t.id_cabecalho = i.id_cabe_img 
        SET c.titulo = :titulo, c.categoria = :categoria, c.autor = :autor, 
            c.editora = :editora, c.premium = :premium,  c.datapublicacao = :datapublicacao,
            i.id_cabe_img = -1, t.texto = :texto WHERE c.id = :idLivro";

        try {
            $p_sql = Conexao::getInstancia()->prepare($sql);
            $p_sql->bindValue(':titulo', $livro['titulo']);
            $p_sql->bindValue(':categoria', $livro['categoria']);
            $p_sql->bindValue(':autor', $livro['autor']);
            $p_sql->bindValue(':datapublicacao', $livro['dataPublicacao']);
            $p_sql->bindValue(':editora', $livro['editora']);
            $p_sql->bindValue(':premium', $livro['premium']);
            $p_sql->bindValue(':texto', $livro['historia']);
            $p_sql->bindValue(':idLivro', $livro['idLivro']);
            $p_sql->execute();
        } catch (Exception $e) {
            echo 'Atualiza livro---';
            print_r($e);
            return false;
        }

        $sql = "UPDATE imagem SET id_cabe_img = :idLivro WHERE id = :idImg";

        try {
            $p_sql = Conexao::getInstancia()->prepare($sql);
            $p_sql->bindValue(':idImg', $livro['idImg']);
            $p_sql->bindValue(':idLivro', $livro['idLivro']);
            $p_sql->execute();
        } catch (Exception $e) {
            echo 'Atualiza Imagem---';
            print_r($e);
            return false;
        }
        return true;
    }
}
