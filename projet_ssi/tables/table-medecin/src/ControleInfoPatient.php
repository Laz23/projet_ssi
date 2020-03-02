<?php
namespace App;

use DateTime;
use DateTimeZone;

class ControleInfoPatient{


        const LIMIT_nom = 3;
       // const LIMIT_MESSAGE = 10;
        private $nom;
        private $prenom;
        private $num_tele ;
       // private $date;

        /**
         * __construct
         *
         * @param  mixed $nom
         * @param  mixed $message
         * @param  mixed $date
         *
         * @return void
         */
        public function __construct(string $nom,string $prenom ,  string $num_tele ){
            $this->nom = $nom;
            $this->prenom = $prenom;
          
            $this->num_tele = $num_tele ; 
        }

        /**
         * isValid
         *
         * @return bool
         */
        public function isValid():bool{
                return empty($this->getError()) ;
        }

        public function getError(){
                $errors = [];
                if(strlen($this->nom) < self::LIMIT_nom ){
                    $errors["nom"] = "Le nom est trop court";
                 }
                 if(strlen($this->prenom) < self::LIMIT_nom ){
                    $errors["prenom"] = "Le prenom est trop court";
                 }


                if(!preg_match("#^[0-9][1-9]([-. ]?[0-9]{2}){4}$#", $this->num_tele) ){
                        $errors["num_tele"] = "Numéro téléphone n'est pas valide " ; 
                    }

                 return $errors;
        }

        /*
        public function toJson(): string{
            return json_encode(
                [
                    "nom" =>$this->nom,
                    "message" => $this->message,
                    "date" => $this->date->getTimestamp()
                    ]
                );
            }
            public function toHtml(): string{
                $this->date->setTimezone(new DateTimeZone("Europe/Berlin"));
                $nom = htmlentities($this->nom);
                $date = $this->date->format("d/m/Y à H:i");
                $message = nl2br(htmlentities($this->message));
                    return <<<HTML
                   <p> <strong>{$nom}</strong> <em> {$date} </em><br>
                   {$message}
            </p>
HTML;
    
            }

            public static function fromJson(string $json):ControleInfoPatient{
                $data = json_decode($json,true);
                return new self($data["nom"], $data["message"],new DateTime("@".$data["date"]));
            }    */        
        }