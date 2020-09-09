<?php

namespace Progen\Generator;

require_once "Cities.php";
use Progen\Generator\Cities;

class Cep
{
    private $zipCode;
    private $address;
    private $addresNumber;
    private $district;
    private $city;
    private $cityCode;
    private $state;
    private $stateAbr;
    private $landline;
    private $cellphone;

    public function __construct($state = null, $city = null, $punctuation = true)
    {
        if ($punctuation) {
            $punctuation = "S";
        } else {
            $punctuation = "N";
        }

        $url = "https://www.4devs.com.br/ferramentas_online.php";
        
        $cities = new Cities($state, $city);
        $getAddress = [
            "acao" => "gerar_pessoa",
            "sexo" => "I",
            "pontuacao" => $punctuation,
            "idade" => 30,
            "cep_estado" => $cities->getStateAbr(),
            "txt_qtde" => 1,
            "cep_cidade" => $cities->getCityCode(),
        ];

        $query = http_build_query($getAddress);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $query);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $decodeData = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($decodeData);
        $curl = $query = $decodeData = null;
        
        $this->zipCode = $data->cep;
        $this->address = $data->endereco;
        $this->addresNumber = $data->numero;
        $this->district = $data->bairro;
        $this->city = $cities->getCity();
        $this->cityCode = $cities->getCityCode();
        $this->stateAbr = $cities->getStateAbr();
        $this->state = $cities->getState();
        $this->landline = $data->telefone_fixo;
        $this->cellphone = $data->celular;
    }

    public function getZipCode()
    {
        return $this->zipCode;
    }
    
    public function getAddress()
    {
        return $this->address;
    }
    
    public function getAddresNumber()
    {
        return $this->addresNumber;
    }
    
    public function getDistrict()
    {
        return $this->district;
    }
    
    public function getCity()
    {
        return $this->city;
    }
    
    public function getCityCode()
    {
        return $this->cityCode;
    }
    
    public function getStateAbr()
    {
        return $this->stateAbr;
    }
    
    public function getState()
    {
        return $this->state;
    }
    
    public function getLandline()
    {
        return $this->landline;
    }
    
    public function getCellphone()
    {
        return $this->cellphone;
    }
    
}