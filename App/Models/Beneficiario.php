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
            
            if ($beneficiario->nome === strtolower($nome)) {

                return ['code'=>200,'dados'=>$beneficiario];
                break;
            }

        }

        return ['code'=>404,'message'=>'Nome não encontrado'];

    }

    public static function create(array $post)
    {
        $beneficiarios = file_get_contents("databases/beneficiarios.json");
        $beneficiarios = json_decode($beneficiarios);

        array_push($beneficiarios, $post);
        //echo json_encode($beneficiarios);

        $f = fopen('databases/beneficiarios.json','w');
        fwrite($f, json_encode($beneficiarios));
        fclose($f);

        return ['code'=>200,'message'=>'Beneficiario inserido com sucesso'];
    }
}
