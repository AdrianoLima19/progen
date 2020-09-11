<?php

namespace Progen\Generator;

use DateTime;
use DateTimeZone;

class Person
{
    private $name;
    private $firstName;
    private $lastName;
    private $age;
    private $cpf;
    private $rg;
    private $cnh;
    private $birth;
    private $gender;
    private $mom;
    private $dad;
    private $email;
    private $password;
    private $landline;
    private $cellphone;
    private $height;
    private $Weight;
    private $bloodType;
    private $zipCode;
    private $address;
    private $addresNumber;
    private $district;
    private $city;
    private $cityCode;
    private $stateAbr;
    private $state;

    public function __construct($punctuation = true, $gender = "I", $state = null, $city = null)
    {
        $url = "https://www.4devs.com.br/ferramentas_online.php";
        
        if ($punctuation) {
            $punctuation = "S";
        } else {
            $punctuation = "N";
        }
        if(strtoupper($gender) == "F") {
            $gender = "M";
        } elseif(strtoupper($gender) == "M") {
            $gender = "H";
        }
        
        $cities = new Cities($state, $city);
        
        $loadArray = [
            'acao' => 'gerar_pessoa',
            'sexo' => $gender,
            'pontuacao' => $punctuation,
            'idade' => 0,
            'cep_estado' => $cities->getStateAbr(),
            'txt_qtde' => 1,
            'cep_cidade' => $cities->getCityCode(),
        ];

        $query = http_build_query($loadArray);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $query);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $personData = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($personData);
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, "acao=gerar_cnh");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $cnh = curl_exec($curl);
        curl_close($curl);

        $name = explode(" ", $data->nome);
        $fname = trim($name[0]);
        array_shift($name);
        $lname = implode(" ", $name);

        $this->name = $data->nome;
        $this->firstName = $fname;
        $this->lastName = $lname;
        $this->age = $data->idade;
        $this->cpf = $data->cpf;
        $this->rg = $data->rg;
        $hourNac = " ".rand(0,24).":".rand(0, 59).":".rand(0, 59).".".rand(000000, 999999);
        $this->birth = new DateTime(str_replace("/", "-", $data->data_nasc).$hourNac, new DateTimeZone('America/Sao_Paulo'));   
        $this->gender = $data->sexo;
        $this->mom = $data->mae;
        $this->dad = $data->pai;
        $this->email = $data->email;
        $this->password = $data->senha;
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
        $this->height = $data->altura;
        $this->Weight = $data->peso;
        $this->bloodType = $data->tipo_sanguineo;
        $this->cnh = $cnh;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }
    
    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }
    
    /**
     * @return integer
     */
    public function getAge()
    {
        return $this->age;
    }
    
    /**
     * @return string
     */
    public function getCpf()
    {
        return $this->cpf;
    }
    
    /**
     * @return string
     */
    public function getRg()
    {
        return $this->rg;
    }
    
    /**
     * @return DateTime
     */
    public function getBirth():DateTime
    {
        return $this->birth;
    }
    
    public function getGender()
    {
        return $this->gender;
    }
    
    public function getMom()
    {
        return $this->mom;
    }
    
    public function getDad()
    {
        return $this->dad;
    }
    
    public function getEmail()
    {
        return $this->email;
    }
    
    public function getPassword()
    {
        return $this->password;
    }
    
    public function getLandline()
    {
        return $this->landline;
    }
    
    public function getCellphone()
    {
        return $this->cellphone;
    }
    
    public function getHeight()
    {
        return $this->height;
    }
    
    public function getWeight()
    {
        return $this->Weight;
    }
    
    public function getBloodType()
    {
        return $this->bloodType;
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
    
    public function getCnh()
    {
        return $this->cnh;
    }
}
