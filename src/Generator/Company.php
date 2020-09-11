<?php

namespace Progen\Generator;

class Company
{

    private $companyName;
    private $cnpj;
    private $stateRegistration;
    private $openingDate;
    private $site;
    private $email;
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

    public function __construct($state = null, $city = null, $openingDate = 1, $punctuation = true)
    {
        $url = "https://www.4devs.com.br/ferramentas_online.php";
        if ($punctuation) {
            $punctuation = "S";
        } else {
            $punctuation = "N";
        }
        $cep = new Cep($state, $city, $punctuation);
        $dataArray = [
            'acao' => 'gerar_empresa',
            'pontuacao' => $punctuation,
            'estado' => $cep->getStateAbr(),
            'idade' => $openingDate,
        ];
        
        $data = http_build_query($dataArray);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($curl);
        curl_close($curl);


        $pattern = '/<input\s?.*?value="([.A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ0-9\/\-\@\s\(\)&&]+)"\s?.*?\/>/';

        preg_match_all($pattern, $response, $match);

        $match[0] = null;
        $data = $match[1];
        
        $this->companyName = $data[0];
        $this->cnpj = $data[1];
        $this->stateRegistration = $data[2];
        $this->openingDate = $data[3];
        $this->site = $data[5];
        $this->email = $data[6];
        $this->zipCode = $cep->getZipCode();
        $this->address = $cep->getAddress();
        $this->addresNumber = $cep->getAddresNumber();
        $this->district = $cep->getDistrict();
        $this->city = $cep->getCity();
        $this->cityCode = $cep->getCityCode();
        $this->state = $cep->getState();
        $this->stateAbr = $cep->getStateAbr();
        $this->landline = $cep->getLandline();
        $this->cellphone = $cep->getCellphone();
    }

    public function getCompanyName()
    {
        return $this->companyName;
    }
    
    public function getCnpj()
    {
        return $this->cnpj;
    }
    
    public function getStateRegistration()
    {
        return $this->stateRegistration;
    }
    
    public function getOpeningDate()
    {
        return $this->openingDate;
    }
    
    public function getSite()
    {
        return $this->site;
    }
    
    public function getEmail()
    {
        return $this->email;
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
    
    public function getState()
    {
        return $this->state;
    }
    
    public function getStateAbr()
    {
        return $this->stateAbr;
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
