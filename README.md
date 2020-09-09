# Progen
Este projeto é um web scraper do [4devs](https://www.4devs.com.br), que gera dados brasileiros válidos. Esses dados `não` servem para fazer compras na internet, mas, para ajudar programadores a testarem seus softwares.

### Instalação
Progen pode ser instalçado via composer
```
"surerloki/progen": "^0.1.1",
```
ou via cmd
```cmd
$ composer require surerloki/progen
```
### Utilização

Progen suporta [psr-4](https://www.php-fig.org/psr/psr-4/)

##### Gerador de Pessoas

```
use Progen\Generator\Person;
$person = new Person();
```
##### Parâmetros
Os parâmetros não são obrigatórios, mas, podem ser adicionados na classe para gerar um usuário especifico.
```
$person = new Person();
$person = new Person($punctuation, $gender, $state, $city);
$person = new Person(true, "M", "SP", "São Paulo");
$person = new Person(true, "F", "RJ", "");
$person = new Person(true, "", "SP", "");
```
##### Métodos
Métodos Para Utilizar os dados gerados pela classe
```
$person->getName();
$person->getFirstName();
$person->getLastName();
$person->getAge();
$person->getCpf();
$person->getRg();
$person->getBirth();
$person->getGender();
$person->getMom();
$person->getDad();
$person->getEmail();
$person->getPassword();
$person->getLandline();
$person->getCellphone();
$person->getHeight();
$person->getWeight();
$person->getBloodType();
$person->getZipCode();
$person->getAddress();
$person->getAddresNumber();
$person->getDistrict();
$person->getCity();
$person->getCityCode();
$person->getStateAbr();
$person->getState();
```

#### Gerar Empresa
##### Parâmetros
```
use Progen\Generator\Company;
$company = new Company($state, $city, $openingDate, $punctuation);
$company = new Company("", "", 15, true);
```
##### Métodos
```
$company->getCompanyName();
$company->getCnpj();
$company->getStateRegistration();
$company->getOpeningDate();
$company->getSite();
$company->getEmail();
$company->getZipCode();
$company->getAddress();
$company->getAddresNumber();
$company->getDistrict();
$company->getCity();
$company->getCityCode();
$company->getState();
$company->getStateAbr();
$company->getLandline();
$company->getCellphone();
```
#### Cartão de Crédito
##### Parâmetros
```
use Progen\Generator\CreditCard;
$creditCard = new CreditCard();
$creditCard = new CreditCard($creditCard, $punctuation);
$creditCard = new CreditCard("Mastercard", true);
```
##### Métodos
```
$creditCard->getCreditCard();
$creditCard->getCardFlag();
$creditCard->getExpirationDate();
$creditCard->getSecurityCode();
```
#### Cep
##### Parâmetros
```
use Progen\Generator\Cep;
$cep = new Cep();
$cep = new Cep($state, $city, $punctuation);
$cep = new Cep("SP", "São Paulo", true);
```
##### Métodos
```
$cep->getZipCode();
$cep->getAddress();
$cep->getAddresNumber();
$cep->getDistrict();
$cep->getCity();
$cep->getCityCode();
$cep->getStateAbr();
$cep->getState();
$cep->getLandline();
$cep->getCellphone();
```
#### Certidão
##### Parâmetros
```
$certificate = new Certificate();
$certificate = new Certificate($certificateType, $punctuation);
$certificate = new Certificate(birth);
$certificate = new Certificate("marriage", true);
```
##### Métodos
```
$certificate->getCertificate();
$certificate->getCertificateType();
```
#### Estado/Cidade
##### Parâmetros
```
$city = new Cities($state, $city, $returnAll);
$city = new Cities($state, $city);
$city = new Cities();
```
##### Métodos
```
$cities->getState();
$cities->getStateAbr();
$cities->getCity();
$cities->getCityCode();
```
#### Gerador Lorem
##### Parâmetros
```
$text = new Lorem(paragraphs, $type, $style);
$text = new Lorem();
$text = new Lorem(4, "long");
```
##### Métodos
```
$text->getText();
```
