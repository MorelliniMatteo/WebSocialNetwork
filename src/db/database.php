<?php
class DatabaseHelper{
    private $db;

    public function __construct($servername, $username, $password, $dbname, $port){
        $this->db = new mysqli($servername, $username, $password, $dbname, $port);
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }        
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    }

    public function getLatestOrders($n=10){
        $query = "SELECT idOrdine, email, dataPagamento, stato, 
            (SELECT GROUP_CONCAT(idMaglia, '.', quantità) 
            FROM maglia_ordinata
            WHERE maglia_ordinata.idOrdine=ordine.idOrdine
            GROUP BY maglia_ordinata.idOrdine) as maglie
            FROM ordine
            ORDER BY dataPagamento DESC 
            LIMIT ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i',$n);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAdmins(){
        $stmt = $this->db->prepare("SELECT email, nome, cognome FROM account WHERE admin=1");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function mostLiked($n = 3){

    }
    
    public function getOrdersOfUser($email){
        $stmt = $this->db->prepare("SELECT dataPagamento, stato, totale, idOrdine FROM ordine WHERE email=? ORDER BY dataPagamento DESC");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getProductsInOrder($idOrder){
        $stmt = $this->db->prepare("SELECT maglia.idMaglia, quantità, nomePersonalizzato, numeroPersonalizzato, costo, immagineFronte, taglia
            FROM maglia_ordinata, maglia WHERE maglia.idMaglia = maglia_ordinata.idMaglia AND idOrdine=?");
        $stmt->bind_param("i", $idOrder);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getProductsInCart($email){
        $stmt = $this->db->prepare("SELECT idRiga, maglia.idMaglia, quantità, nomePersonalizzato, numeroPersonalizzato, costo, immagineFronte, taglia
            FROM maglia_in_carrello, maglia WHERE maglia.idMaglia = maglia_in_carrello.idMaglia AND email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function checkLogin($email, $password){
        $query = "SELECT email, password, admin FROM account WHERE email = ? AND password = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ss', $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    } 

    public function changePassword($email, $vecchiaPassword, $nuovaPassword){
        $query = "UPDATE account SET password = ? WHERE email = ? AND password = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sss', $nuovaPassword, $email, $vecchiaPassword);
        $stmt->execute();

        return $stmt->affected_rows;
    } 

    public function register($email, $nome, $cognome, $password, $telefono){
        $query = "INSERT INTO account (email, nome, cognome, password, numeroTelefono)
            VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sssss', $email, $nome, $cognome, $password, $telefono);
        $stmt->execute();

        return $stmt->affected_rows;
    } 
    
    public function alreadyRegistered($email){
        $query = "SELECT email FROM account WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addToProduct($id, $qta){
        $query = "UPDATE maglia SET dispMagazzino = dispMagazzino + ? WHERE idMaglia = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $qta, $id);
        $stmt->execute();

        return $stmt->affected_rows;
    }

    public function insertProduct($modello, $colore, $taglia, $genere, $dispMagazzino, $prezzo, $imgFronte, $imgRetro){
        $query = "INSERT INTO maglia (idModello, idColore, taglia, idGenere, dispMagazzino,
            prezzo, immagineFronte, immagineRetro) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('iisiiiss', $modello, $colore, $taglia, $genere, $dispMagazzino,
            $prezzo, $imgFronte, $imgRetro);
        $stmt->execute();

        return $stmt->insert_id;
    }

    public function updateProduct($id, $prezzo, $taglia, $immagineFronte, $immagineRetro, $dispMagazzino){
        $query = "UPDATE maglia SET dispMagazzino = ?, prezzo = ?, taglia = ?,
        immagineFronte = ?, immagineRetro = ? WHERE idMaglia = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('iisssi', $dispMagazzino, $prezzo, $taglia,
            $immagineFronte, $immagineRetro, $id);
        $stmt->execute();

        return $stmt->affected_rows;
    }

    public function removeProduct($id){
        $query = "UPDATE maglia SET dispMagazzino = 0 WHERE idMaglia = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();

        return $stmt->affected_rows;
    }

    public function numberOfProductInCart($id, $email){
        $query = "SELECT quantità FROM maglia_in_carrello WHERE idMaglia = ? AND email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('is', $id, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        $tot = 0;
        foreach($result as $value){
            $tot += $value["quantità"];
        }

        return $tot;
    }

    public function executeOrder($email){
        $error = false;
        $maglie = $this->getProductsInCart($email);
        $totale = 0.0;
        foreach($maglie as $maglia){
            $totale += $maglia["costo"];
        }
        //inserimento ordine
        $stato = "Ordine confermato, consegna prevista al Campus entro 5 giorni lavorativi!";
        $query = "INSERT INTO ordine (email, dataPagamento, stato, totale) 
            VALUES (?, CURRENT_TIMESTAMP(), ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ssd', $email, $stato, $totale);
        $stmt->execute();

        $idOrder = $stmt->insert_id;
        if(!($idOrder>0)){
            return true;
        }

        //inserimento delle maglie nell'ordine, diminuzione scorte e aumento vendite
        $query = "INSERT INTO maglia_ordinata (idMaglia, idOrdine, quantità, nomePersonalizzato, numeroPersonalizzato, costo) 
            VALUES (?, ?, ?, ?, ?, ?)";
        $query2 = "UPDATE maglia SET dispMagazzino = dispMagazzino - ?, vendite = vendite + ? WHERE idMaglia = ?";
        
        if(count($maglie) == 0){
            return true;
        }
        foreach($maglie as $maglia){
            //la metto nell'ordine
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('iiisid', $maglia["idMaglia"], $idOrder,
                $maglia["quantità"], $maglia["nomePersonalizzato"],
                $maglia["numeroPersonalizzato"], $maglia["costo"]);
            $stmt->execute();
            $id = $stmt->insert_id;
            if(!($idOrder>0)){
                return true;
            }
            //la tolgo dal magazzino
            $stmt = $this->db->prepare($query2);
            $stmt->bind_param('iii', $maglia["quantità"], $maglia["quantità"], $maglia["idMaglia"]);
            $stmt->execute();
            if($stmt->affected_rows!=1){
                return true;
            }
        }

        //cancellazione delle maglie nel carrello
        $query = "DELETE FROM maglia_in_carrello WHERE email=?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();

        if(!($stmt->affected_rows>0)){
            return true;
        }
        return false;
    }

    public function addToCart($idMaglia, $email, $quantità, $nome, $numero, $costo) {
        $query = "INSERT INTO maglia_in_carrello (idMaglia, email, quantità, nomePersonalizzato, numeroPersonalizzato, costo) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('isisid', $idMaglia, $email, $quantità, $nome, $numero, $costo);
        $stmt->execute();

        return $stmt->insert_id;
    }

    public function removeFromCart($idRiga){
        $query = "DELETE FROM maglia_in_carrello WHERE idRiga = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $idRiga);
        $stmt->execute();

        return $stmt->affected_rows;
    }
}
?>
