<?php 

namespace App\Controllers;

use App\Validators\EconometreValidator;
use Exception;

class EconometreController extends Controller
{
    /**
     * Fonction d'entrée pour les calcule pour l'économètre
     */
    public function calcul(){
        $validator = new EconometreValidator($this->request);
        $request_validated = $validator->validate();

        $lua_params_string = [];

        foreach (['Occupation', 'Departement', 'Ville', 'Surface', 'Annee_const', 'Vitrage', 'Travaux', 'Nb_occupants', 'T_cons', 'Syst_actuel', 'Age_syst','Emetteurs', 'Syst_ECS_actuel', 'Chgmt_ECS'] as $key) {

            $value = $request_validated[$key];
            if(is_array($value)){
                $value = $this->arrayToLuaParams($value,false);
            }
            $lua_params_string[$key] = $value;
        }

        $reponse = $this->callLuaFile($this->arrayToLuaParams($lua_params_string,true));

        displayResponse(200,[
            'results' => $reponse
        ]);
    }

    /**
     * Appel le fichier LUA intermédiaire pour avoir la réponse ce MOTEUR_ECO
     */
    private function callLuaFile(string $ECO_IN) :array{
        $str = 'ECO_IN = '.$ECO_IN;

        $descriptorspec = array(
        0 => array("pipe", "r"), // stdin
        1 => array("pipe", "w"), // stdout
        2 => array("pipe", "w"), // stderr
        );

        $cwd = getConfiguration('lua_path');

        $env = [];

        $process = proc_open('lua '.getConfiguration('lua_file_name'), $descriptorspec, $pipes, $cwd, $env);
        if (is_resource($process)) {
            // on écrit sur le stdin de lua
            fwrite($pipes[0], $str);
            fclose($pipes[0]);

            $response = stream_get_contents($pipes[1]);
            fclose($pipes[1]);

            $errors = stream_get_contents($pipes[2]);
            fclose($pipes[2]);

            // Il est important que vous fermiez les pipes avant d'appeler
            // proc_close afin d'éviter un verrouillage.
            $return_value = proc_close($process);

            if($return_value === 0){
                return json_decode($response,true);
            }else{
                throw new Exception($errors,500);
            }
        }else{
            throw new Exception('Process lua inconnu.',500);
        }
    }


    /**
     * Convertie un tableau en une chaine de caractère compréhensible pour LUA
     */
    private function arrayToLuaParams(array $array, bool $withkeys) :string{
        $return = '{';
        foreach ($array as $key => $value) {
            $return .= ( $withkeys ? $key.'=' : '').$value.',';
        }
        $return = trim($return,',').'}';
        return $return;
    }
}
