<?php

namespace Progen\Generator;

class Cities
{
    private $state;
    private $stateAbr;
    private $city;
    private $cityCode;

    /**
     * @param string $state
     * @param string $city
     * @param boolean $returnAll
     */
    public function __construct($state = null, $city = null, $returnAll = false)
    {
        $url = "https://www.4devs.com.br/ferramentas_online.php";
        $stateArray = [
            "AC" => "Acre",
            "AL" => "Alagoas",
            "AP" => "Amapá",
            "AM" => "Amazonas",
            "BA" => "Bahia",
            "CE" => "Ceará",
            "DF" => "Distrito Federal",
            "ES" => "Espírito Santo",
            "GO" => "Goiás",
            "MA" => "Maranhão",
            "MT" => "Mato Grosso",
            "MS" => "Mato Grosso do Sul",
            "MG" => "Minas Gerais",
            "PA" => "Pará",
            "PB" => "Paraíba",
            "PR" => "Paraná",
            "PE" => "Pernambuco",
            "PI" => "Piauí",
            "RJ" => "Rio de Janeiro",
            "RN" => "Rio Grande do Norte",
            "RS" => "Rio Grande do Sul",
            "RO" => "Rondônia",
            "RR" => "Roraima",
            "SC" => "Santa Catarina",
            "SP" => "São Paulo",
            "SE" => "Sergipe",
            "TO" => "Tocantins",
        ];
        
        if (!empty($state)) {
            foreach ($stateArray as $key => $value) {
                if (mb_strtolower($state) == mb_strtolower($value)) {
                    $stateAbr = strtoupper($key);
                    $state = $value;
                    break;
                }else if (mb_strtolower($state) == mb_strtolower($key)) {
                    $stateAbr = strtoupper($key);
                    $state = $value;
                    break;
                }
            }
        }

        if (!isset($stateAbr)) {
            $stateAbr = array_rand($stateArray, 1);
            $state = $stateArray[$stateAbr];
        }

        $loadCities = [
            'acao' => 'carregar_cidades',
            'cep_estado' => $stateAbr,
        ];

        $query = http_build_query($loadCities);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $query);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        curl_close($curl);

        $regex = '/<option\s?value="([0-9]+)">\s?.*?([a-zA-Z-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ0\s]+)\s?.*?<\/option>/';
        preg_match_all($regex, $data, $cities);
        $cities[0] = $curl = $query = $data = null;
        $cities = array_filter($cities);
        sort($cities);

        if ($returnAll) {
            $this->state = $state;
            $this->stateAbr = $stateAbr;
            $this->city = $cities[1];
            $this->cityCode = $cities[0];

            return true;
        }

        if (!empty($city)) {
            $cityFormatted =  preg_replace('/[^A-Za-zzáàâãéèêíïóôõöüúçñÁÀÂÃÉÈÍÏÓÔÕÖÜÚÇÑ0]/', '', utf8_decode($city));
            for ($i=0; $i < count($cities[0]); $i++) { 
                $citiesFormatted = preg_replace('/[^A-Za-zzáàâãéèêíïóôõöüúçñÁÀÂÃÉÈÍÏÓÔÕÖÜÚÇÑ0]/', '', utf8_decode($cities[1][$i]));
                if (strtolower($cityFormatted) == strtolower($citiesFormatted)) {
                    $city = $cities[1][$i];
                    $cityCode = $cities[0][$i];
                    break;
                }
            }
        }
        if(empty($cityCode)){
            $randId = array_rand($cities[0], 1);
            $city = $cities[1][$randId];
            $cityCode = $cities[0][$randId];
        }

        $this->state = $state;
        $this->stateAbr = $stateAbr;
        $this->city = $city;
        $this->cityCode = $cityCode;

    }

    /**
     * @return string|null
     */
    public function getState():?string
    {
        return $this->state;
    }
    
    /**
     * @return string|null
     */
    public function getStateAbr():?string
    {
        return $this->stateAbr;
    }
    
    /**
     * @return string|array|null
     */
    public function getCity()
    {
        return $this->city;
    }
    
    /**
     * @return string|array|null
     */
    public function getCityCode()
    {
        return $this->cityCode;
    }
}
