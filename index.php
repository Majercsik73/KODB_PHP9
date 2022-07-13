<?php 
    //Útvonal lekérése
    $parsed = parse_url($_SERVER['REQUEST_URI']);

    $path = $parsed['path'];
    //var_dump($path);
    switch ($path){
        case "/KODB_PHP9/penzvalto":
            // 1.Mellékhatás Request query paraméterek beolvasása
            $value = (int)($_GET['mennyit'] ?? 12);
            $sourceCurrency = $_GET['mirol'] ?? 'USD';
            $targetCurrency = $_GET['mire'] ?? 'HUF';

            //2.Mellékhatás átváltási ráta beolvasása
            $content = file_get_contents("https://kodbazis.hu/api/exchangerates?base=".$sourceCurrency);
            //var_dump($content);
            $decoded = json_decode($content, true);
            //var_dump($decoded);

            //3. Számítás
            $eredmeny = $decoded['rates'][$targetCurrency] * $value;
            //echo $eredmeny;

            //4. Valuta adatok beolvasása saját file-ból
            $currencies = json_decode(file_get_contents("./currencies.json"), true);

            require "./views/converter.php"; //ezzel hívjuk be a pénzváltó html oldal kigenerálását
            break;

        case "/KODB_PHP9/":  // az XAMPP apache szerver miatt szükséges az utolsó '/' jel!!!
            require "./views/home.html"; // ezzel hívjuk be a home/főoldal html oldal kigenerálását
            break;

        default:
            echo "Oldal nem található <a href='/'> Vissza a címoldalra </a>";
    }


?>


