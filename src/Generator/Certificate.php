<?php

namespace Progen\Generator;

class Certificate
{
    private $certificate;
    private $certificateType;

    public function __construct($certificateType = null, $punctuation = true)
    {
        $url = "https://www.4devs.com.br/ferramentas_online.php";
        if ($punctuation) {
            $punctuation = "S";
        } else {
            $punctuation = "N";
        }
        $valideCertificates = [
            'indifferent',
            'birth',
            'marriage',
            'religiousmarriage',
            'death',
        ];
        $curlInput = [
            'Indiferente',
            'nascimento',
            'casamento',
            'casamento_religioso',
            'obito',
        ];
        $formatedOutput = [
            'Indiferente',
            'Nascimento',
            'Casamento',
            'Casamento Religioso',
            'Óbito',
        ];

        if ($certificateType) {
            $key = array_search(strtolower($certificateType), $valideCertificates);
        }

        if (!isset($key)) {
            $certificateType = "Indiferente";
            $key = 0;
        } else {
            $certificateType = $curlInput[$key];
        }

        $loadArray = [
            'acao' => 'gerador_certidao',
            'pontuacao' => $punctuation,
            'tipo_certidao' => $certificateType,
        ];

        $query = http_build_query($loadArray);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $query);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        curl_close($curl);

        $this->certificate = $data;
        $this->certificateType = $formatedOutput[$key];
    }
    
    public function getCertificate()
    {
        return $this->certificate;
    }
    
    public function getCertificateType()
    {
        return $this->certificateType;
    }
    
}