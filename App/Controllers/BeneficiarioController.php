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
            $_POST['quantidade'] = (int) $_POST['quantidade'];
            $_POST['idade'] = (int) $_POST['idade'];

            $beneficiario = Beneficiario::get($_POST['nome']);
            if ($beneficiario['code'] == 200) {
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

}
