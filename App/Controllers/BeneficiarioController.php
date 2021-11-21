<?php 

namespace App\Controllers;

use App\Models\Beneficiario;
use App\Models\Plano;

class BeneficiarioController
{

    public static function get(string $nome = null)
    {
        if (isset($nome)) {

            return Beneficiario::get($nome);
        } else {
            return Beneficiario::all();
        }
    }

    public static function post()
    {
        if ((isset($_POST['nome'])) && (isset($_POST['idade'])) &&(isset($_POST['quantidade'])) &&(isset($_POST['registro']))) {

            //casting
            $_POST['nome'] = mb_strtoupper($_POST['nome']);
            $_POST['quantidade'] = (int) $_POST['quantidade'];
            $_POST['idade'] = (int) $_POST['idade'];

            $beneficiario = Beneficiario::get($_POST['nome']);
            if ($beneficiario['code'] === 200) {
                return ['code'=>404,'message'=>'Não foi possível cadastrar o Benefíciário. Beneficiário já existe'];
            }

            foreach (Plano::all()['dados'] as $plano) {

                //verifica se o registro existe
                if ($plano->registro ===  $_POST['registro']) {

                    foreach ($plano->precos as $preco) {

                        //verifica se o numero de beneficiarios selecionado bate com o registro
                        if ($preco->minimo_vidas === $_POST['quantidade']) {

                            if ($_POST['idade'] <= 17) {
                                $_POST['preco'] = $preco->faixa1;
                            } else if ($_POST['idade'] <= 40) {
                                $_POST['preco'] = $preco->faixa2;
                            } else {
                                $_POST['preco'] = $preco->faixa3;
                            }
                            return Beneficiario::create($_POST);

                        }


                    } 
                    return ['code'=>404,'message'=>'Não foi possível cadastrar o Benefíciário. Quantidade incompatível com o plano escolhido'];

                }

            }
            return ['code'=>404,'message'=>'Não foi possível cadastrar o Benefíciário. Registro inexistente'];

            
        }
        
    }

    public static function put(string $nome)
    {
        parse_str(file_get_contents("php://input"), $_PUT);

        if ((isset($_PUT['nome'])) && (isset($_PUT['idade'])) && (isset($_PUT['quantidade'])) && (isset($_PUT['registro']))) {

            //casting
            $_PUT['nome'] = mb_strtoupper($_PUT['nome']);
            $_PUT['quantidade'] = (int) $_PUT['quantidade'];
            $_PUT['idade'] = (int) $_PUT['idade'];

            $beneficiario = Beneficiario::get($_PUT['nome']);
            if ($beneficiario['code'] === 200) {
                if ($_PUT['nome'] !== mb_strtoupper($nome)) {
                    return ['code'=>404,'message'=>'Não foi possível alterar o Benefíciário. Beneficiário já existe'];
                }
            }

            foreach (Plano::all()['dados'] as $plano) {

                //verifica se o registro existe
                if ($plano->registro ===  $_PUT['registro']) {

                    foreach ($plano->precos as $preco) {

                        //verifica se o numero de beneficiarios selecionado bate com o registro
                        if ($preco->minimo_vidas === $_PUT['quantidade']) {

                            if ($_PUT['idade'] <= 17) {
                                $_PUT['preco'] = $preco->faixa1;
                            } else if ($_PUT['idade'] <= 40) {
                                $_PUT['preco'] = $preco->faixa2;
                            } else {
                                $_PUT['preco'] = $preco->faixa3;
                            }
                            return Beneficiario::update($nome,$_PUT);

                        }


                    } 
                    return ['code'=>404,'message'=>'Não foi possível alterar o Benefíciário. Quantidade incompatível com o plano escolhido'];

                }

            }
            return ['code'=>404,'message'=>'Não foi possível alterar o Benefíciário. Registro inexistente'];

            
        }
    }

    public static function delete(string $nome)
    {
        return Beneficiario::delete($nome);
    }

}
