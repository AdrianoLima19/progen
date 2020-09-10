<?php

namespace Progen\Generator;

require_once "Cities.php";
use Progen\Generator\Cities;

class BankAccount
{
    private $currentAccount;
    private $agency;
    private $bank;
    private $city;
    private $state;
    private $stateAbr;

    public function __construct($punctuation = true, $bank = null, $state = null, $city = null)
    {
        $url = "https://www.4devs.com.br/ferramentas_online.php";
        
        if ($punctuation) {
            $punctuation = "S";
        } else {
            $punctuation = "N";
        }
        
        $cities = new Cities($state, $city);

        $disponibleBanks = [
            "Indiferente" => "",
            "Banco do Brasil" => 2,
            "Bradesco" => 121,
            "CitiBank" => 85,
            "Itaú" => 120,
            "Santander" => 151,
        ];

        if ($bank) {
            foreach ($disponibleBanks as $bankKey => $bankId) {
                if (strtolower(trim($bank)) == strtolower(trim($bankKey))) {
                    $bank = $bankKey;
                    $bankId = $bankId;
                    break;
                }
            }
        }
        if (!isset($bankId)) {
            $bank = array_rand($disponibleBanks, 1); 
            $bankId = $disponibleBanks[$bank];
        }

        $loadArray = [
            'acao'=> "gerar_conta_bancaria",
            'estado'=> $cities->getStateAbr(),
            'banco'=> $bankId,
        ];

        $query = http_build_query($loadArray);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $query);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $bankData = curl_exec($curl);
        curl_close($curl);

        $regex = '/<div\s?.*?>([0-9a-zA-Zú\-\s]+)\s?<span\s?.*?>/';
        preg_match_all($regex, $bankData, $data);
        
        $this->currentAccount = $data[1][0];
        $this->agency = $data[1][1];
        $this->bank = $data[1][2];
        $this->city = $cities->getCity();
        $this->state = $cities->getState();
        $this->stateAbr = $cities->getStateAbr();
    }

    public function getCurrentAccount()
    {
        return $this->currentAccount;
    }
    
    public function getAgency()
    {
        return $this->agency;
    }
    
    public function getBank()
    {
        return $this->bank;
    }
    
    public function getCity()
    {
        return $this->city;
    }
    
    public function getState()
    {
        return $this->state;
    }
    
    public function getStateAbr()
    {
        return $this->stateAbr;
    }
}