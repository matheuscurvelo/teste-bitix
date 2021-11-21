<?php 

namespace App\Models;

class Beneficiario
{

    public static function all()
    {
        $beneficiarios = file_get_contents("databases/beneficiarios.json");
        $beneficiarios = json_decode($beneficiarios);

        $data = [];

        foreach ($beneficiarios as $beneficiario) {
            array_push($data,$beneficiario);
        }

        return ['code'=>200,'dados'=>$data];

    }

    public static function get(string $nome)
    {
        $beneficiarios = file_get_contents("databases/beneficiarios.json");
        $beneficiarios = json_decode($beneficiarios);

        foreach ($beneficiarios as $beneficiario) {
            
            if ($beneficiario->nome === mb_strtoupper($nome)) {

                return ['code'=>200,'dados'=>$beneficiario];
            }

        }

        return ['code'=>404,'message'=>'Beneficiário não encontrado'];

    }

    public static function create(array $post)
    {
        $beneficiarios = file_get_contents("databases/beneficiarios.json");
        $beneficiarios = json_decode($beneficiarios);

        array_push($beneficiarios, $post);

        $f = fopen('databases/beneficiarios.json','w');
        fwrite($f, json_encode($beneficiarios));
        fclose($f);

        return ['code'=>200,'message'=>'Beneficiario inserido com sucesso'];
    }

    public static function update(string $nome, array $put)
    {
        $beneficiarios = file_get_contents("databases/beneficiarios.json");
        $beneficiarios = json_decode($beneficiarios);

        foreach ($beneficiarios as $key => $beneficiario) {
            
            if ($beneficiario->nome === mb_strtoupper($nome)) {

                $beneficiario->nome = $put['nome'];
                $beneficiario->idade = $put['idade'];
                $beneficiario->registro = $put['registro'];
                $beneficiario->quantidade = $put['quantidade'];
                $beneficiario->preco = $put['preco'];

                $f = fopen('databases/beneficiarios.json','w');
                fwrite($f, json_encode($beneficiarios));
                fclose($f);

                return ['code'=>200,'message'=>'Beneficiario alterado com sucesso'];
            }

        }

        return ['code'=>404,'message'=>'Beneficiário inexistente'];

    }

    public static function delete(string $nome)
    {
        $beneficiarios = file_get_contents("databases/beneficiarios.json");
        $beneficiarios = json_decode($beneficiarios);

        $copy = [];

        foreach ($beneficiarios as $key => $beneficiario) {
            
            if ($beneficiario->nome !== mb_strtoupper($nome)) {

                array_push($copy, $beneficiario);

            } else {
                $encontrado = true;
            }

        }

        $f = fopen('databases/beneficiarios.json','w');
        fwrite($f, json_encode($copy));
        fclose($f);

        if (isset ($encontrado)) {
            return ['code'=>200,'message'=>'Beneficiario removido com sucesso'];
        } else {
            return ['code'=>404,'message'=>'Beneficiário inexistente'];
        }


    }
}
