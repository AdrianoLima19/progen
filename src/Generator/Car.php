<?php

namespace Progen\Generator;

class Car 
{
    private $brand;
    private $model;
    private $year;
    private $renavam;
    private $licensePlate;
    private $color;

    public function __construct($punctuation = true, $carBrand = null, $state = null)
    {
        $url = "https://www.4devs.com.br/ferramentas_online.php";
        if ($punctuation) {
            $punctuation = "S";
        } else {
            $punctuation = "N";
        }
        $disponibleCars = [
            '1'   => 'Acura',
            '2'   => 'Agrale',
            '3'   => 'Alfa Romeo',
            '4'   => 'AM Gen',
            '5'   => 'Asia Motors',
            '6'   => 'Audi',
            '7'   => 'BMW',
            '8'   => 'BRM',
            '9'   => 'Buggy',
            '10'  => 'Cadillac',
            '11'  => 'CBT Jipe',
            '12'  => 'Chrysler',
            '13'  => 'Citroen',
            '14'  => 'Cross Lander',
            '15'  => 'Daewoo',
            '16'  => 'Daihatsu',
            '17'  => 'Dodge',
            '18'  => 'Engesa',
            '19'  => 'Envemo',
            '20'  => 'Ferrari',
            '21'  => 'Fiat',
            '22'  => 'Ford',
            '23'  => 'Chevrolet',
            '24'  => 'Gurgel',
            '25'  => 'Honda',
            '26'  => 'Hyundai',
            '27'  => 'Isuzu',
            '28'  => 'Jaguar',
            '29'  => 'Jeep',
            '30'  => 'JPX',
            '31'  => 'Kia Motors',
            '32'  => 'Lada',
            '33'  => 'Land Rover',
            '34'  => 'Lexus',
            '35'  => 'Lotus',
            '36'  => 'Maserati',
            '37'  => 'Matra',
            '38'  => 'Mazda',
            '39'  => 'Mercedes-Benz',
            '40'  => 'Mercury',
            '41'  => 'Mitsubishi',
            '42'  => 'Miura',
            '43'  => 'Nissan',
            '44'  => 'Peugeot',
            '45'  => 'Plymouth',
            '46'  => 'Pontiac',
            '47'  => 'Porsche',
            '48'  => 'Renault',
            '49'  => 'Rover',
            '50'  => 'Saab',
            '51'  => 'Saturn',
            '52'  => 'Seat',
            '54'  => 'Subaru',
            '55'  => 'Suzuki',
            '56'  => 'Toyota',
            '57'  => 'Troller',
            '58'  => 'Volvo',
            '59'  => 'VW - VolksWagen',
            '120' => 'Walk',
            '123' => 'Bugre',
            '125' => 'SSANGYONG',
            '127' => 'LOBINI',
            '136' => 'CHANA',
            '140' => 'Mahindra',
            '147' => 'EFFA',
            '149' => 'Fibravan',
            '152' => 'HAFEI',
            '153' => 'GREAT WALL',
            '154' => 'JINBEI',
            '156' => 'MINI',
            '157' => 'smart',
            '161' => 'CHERY',
            '163' => 'Wake',
            '165' => 'TAC',
            '167' => 'MG',
            '168' => 'LIFAN',
            '170' => 'Fyber',
            '171' => 'LAMBORGHINI',
            '177' => 'JAC',
            '182' => 'CHANGAN',
            '183' => 'SHINERAY',
            '185' => 'RAM',
            '186' => 'RELY',
            '189' => 'ASTON MARTIN',
            '190' => 'FOTON',
            '195' => 'Rolls-Royce',
            '199' => 'GEELY',
        ];
        
        if (!empty($carBrand)) {
            $carBrand = strtolower(trim($carBrand));
            foreach ($disponibleCars as $carId =>$car) {
                if ($carBrand == strtolower(trim($car))) {
                    $carId = $carId;
                    $car = $car;
                    break;
                }
            }
        }
        if (!isset($carId)) {
            $carId = array_rand($disponibleCars, 1);
            $car = $disponibleCars[$carId];
        }

        $cities = new Cities($state);
        
        $loadCurl = [
            'acao'              => "gerar_veiculo",
            'pontuacao'         => $punctuation,
            'estado'            => $cities->getStateAbr(),
            'fipe_codigo_marca' => $carId,
        ];

        $query = http_build_query($loadCurl);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $query);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        curl_close($curl);

        $regex = '/<input\s?.*?value="([a-zA-Z0-9\s\-._\/()]+)"\s?.*?\/>/';
        preg_match_all($regex, $data, $carData);

        $this->brand = $carData[1][0];
        $this->model = $carData[1][1];
        $this->year = $carData[1][2];
        $this->renavam = $carData[1][3];
        $this->licensePlate = $carData[1][4];
        $this->color = $carData[1][5];
    }

    public function getBrand()
    {
        return $this->brand;
    }
    
    public function getModel()
    {
        return $this->model;
    }
    
    public function getYear()
    {
        return $this->year;
    }
    
    public function getRenavam()
    {
        return $this->renavam;
    }
    
    public function getLicensePlate()
    {
        return $this->licensePlate;
    }
    
    public function getColor()
    {
        return $this->color;
    }
}
