<?php

namespace Progen\Generator;

class CreditCard
{
    private $creditCard;
    private $cardNumber;
    private $expirationDate;
    private $securityCode;

    public function __construct($creditCard = null, $punctuation = true)
    {
        $url = "https://www.4devs.com.br/ferramentas_online.php";
        if ($punctuation) {
            $punctuation = "S";
        } else {
            $punctuation = "N";
        }

        $disponibleCards = [
            "MasterCard" => "master",
            "Visa" => "visa16",
            "American Express" => "amex",
            "Diners Club" => "diners",
            "Discover" => "discover",
            "enRoute" => "enroute",
            "JCB" => "jcb",
            "Voyager" => "voyager",
            "HiperCard" => "hiper",
            "Aura" => "aura",
        ];

        if (!empty($creditCard)) {
            $creditCard = strtolower(trim($creditCard));
            foreach ($disponibleCards as $card => $cardsId) {
                if (strtolower(trim($card)) == $creditCard) {
                    $creditCard = $card;
                    $cardId = $cardsId;
                    break;
                }
            }
        } 

        if(!isset($cardId)) {
            $creditCard = array_rand($disponibleCards, 1); 
            $cardId = $disponibleCards[$creditCard];
        }

        $loadArray = [
            'acao' => 'gerar_cc',
            'pontuacao' => $punctuation,
            'bandeira' => $cardId,
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
        
        $regex = '/<div\s?.*?>([0-9a-zA-Z\s\/]+)\s?<span\s?.*?>/';

        preg_match_all($regex, $data, $cardInfo);

        $data = $curl = $cardInfo[0] = null;

        $this->creditCard = $creditCard;
        $this->cardNumber = $cardInfo[1][0];
        $this->expirationDate = $cardInfo[1][1];
        $this->securityCode = $cardInfo[1][2];
    }

    public function getCreditCard()
    {
        return $this->creditCard;
    }
    
    public function getCardNumber()
    {
        return $this->cardNumber;
    }
    
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }
    
    public function getSecurityCode()
    {
        return $this->securityCode;
    }
}
