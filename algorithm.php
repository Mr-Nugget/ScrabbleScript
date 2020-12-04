<?php

    // Vérifie si un tirage et un mot sont des anagrammes avec prises en compte du nombre de jocer
    function checkLetters($draw, $word, $joker){
        // converti la chaine en tableau de char
        $drawArr = str_split($draw);
        $wordArr = str_split($word);
        
        // parcours les charactères du mot
        foreach($wordArr as $char){
            // Si le tirage ne contient pas une lettre du mot et qu'il n'y a plus de joker
            if(!in_array($char, $drawArr) && $joker == 0){
                return false;
            }
            // Sinon s'il reste un joker on décrémente le nb de joker restant
            else if(!in_array($char, $drawArr) && $joker > 0){
                $joker--;
            }
            // Sinon on retire le charactère du tirage, il a bien été traité
            else{
                $key = array_search($char, $drawArr);
                unset($drawArr[$key]);
            }
        }

        // Si on arrive jusque là c'est que le tableau de char du tirage est vide et que l'anagramme est validé
        return true;
    }

    function anagramAlgo($draw, $nbJoker){
        $res = [];

        // chargement des dicitionnaires de mots
        $words7 = file_get_contents("words7.txt", "r");
        $words8 = file_get_contents("words8.txt", "r");
        // conversion en tableau
        $wordArr7 = explode(',', $words7);
        $wordArr8 = explode(',', $words8);

        $lgt = strlen($draw);

        // par défaut on utilise le dictionnaire de 8 mots
        $dictUsed = $wordArr8;

        // sauf si on doit utiliser celui de 7
        if(($lgt == 7 && $nbJoker == 0) || ($lgt == 6 && $nbJoker == 1)){
            $dictUsed = $wordArr7;
        }

        foreach($dictUsed as $word){
            if(checkLetters($draw, $word, $nbJoker)){
                array_push($res, $word);
            }
        }

        return $res;
    }

    // Fonction principale
    function main(){
        // tirage
        $draw = "MANGER";
        // nombre de jockers
        $nbJoker = 2;

        // tableau des anagrammes trouvés
        $res = anagramAlgo($draw, $nbJoker);

        echo "Nombre de mot(s) trouvé(s) : ";
        print_r(count($res));
        echo "\n -> ";

        foreach($res as $word){
            echo $word;
            echo "\n";
        }
    }
    

    // Lancement du programme
    main();
    
?>