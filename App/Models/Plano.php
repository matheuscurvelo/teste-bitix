<?php 

namespace App\Models;

class Plano
{

    public static function all()
    {
        $planos = file_get_contents("databases/plans.json");
        $precos = file_get_contents("databases/prices.json");
        $beneficiarios = file_get_contents("databases/beneficiarios.json");


        $planos = json_decode($planos);
        $precos = json_decode($precos);
        $beneficiarios = json_decode($beneficiarios);

        $data = [];


        foreach ($planos as $plano) {
            $preco_total = 0;

            array_push($data,$plano);
            $data[count($data)-1]->precos = [];
            $data[count($data)-1]->beneficiarios = [];

            foreach ($precos as $preco) {
                if ($plano->codigo === $preco->codigo) {
                    array_push($data[count($data)-1]->precos,$preco);
                }
            }

            foreach ($beneficiarios as $beneficiario) {
                if ($plano->registro === $beneficiario->registro) {     
                    $preco_total += $beneficiario->preco;
                    array_push($data[count($data)-1]->beneficiarios,$beneficiario);
                }
            }

            $data[count($data)-1]->preco_total = $preco_total;
        }

    
        $f = fopen('databases/proposta.json','w');
        fwrite($f, json_encode($data));
        fclose($f);

        return ['code'=>200,'dados'=>$data];

    }

    public static function get(int $codigo)
    {
        $planos = file_get_contents("databases/plans.json");
        $precos = file_get_contents("databases/prices.json");
        $beneficiarios = file_get_contents("databases/beneficiarios.json");

        $planos = json_decode($planos);
        $precos = json_decode($precos);
        $beneficiarios = json_decode($beneficiarios);


        foreach ($planos as $plano) {
            
            if ($plano->codigo === $codigo) {
                $preco_total = 0;
                $plano->precos = [];
                $plano->beneficiarios = [];

                foreach ($precos as $preco) {
                    if ($plano->codigo === $preco->codigo) {
                        array_push($plano->precos,$preco);
                    }
                }

                foreach ($beneficiarios as $beneficiario) {
                    if ($plano->registro === $beneficiario->registro) {
                        $preco_total += $beneficiario->preco;
                        array_push($plano->beneficiarios,$beneficiario);
                    }
                }

                $plano->preco_total = $preco_total;

                return ['code'=>200,'dados'=>$plano];
                break;
            }

        }

        return ['code'=>404,'message'=>'Código não encontrado'];

    }

}
