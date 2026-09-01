<?php

    class Entity extends Conexao{

        //Listar
        public function list($table)
        {
            $pdo = parent::getInstance();

            $sql = "SELECT * FROM $table ORDER BY id ASC";

            $statement = $pdo->query($sql);
            $statement->execute();

            return $statement->fetchAll();
        }

        public function listPropostas()
        {
            $pdo = parent::getInstance();

            $sql = "SELECT p.id, p.id_usuario, p.id_cliente, p.path_pdf, p.data_criacao, p.status, f.nome AS usuario
                    FROM proposta p
                    JOIN funcionario f ON f.id = p.id_usuario
                    ORDER BY p.data_criacao DESC";

            $statement = $pdo->query($sql);
            $statement->execute();

            return $statement->fetchAll();

        }

        public function getDadosMaquinas($idProposta){
            $pdo = parent::getInstance();

            $sql = "SELECT m.*
                    FROM proposta_maquina pm
                    INNER JOIN maquina m ON m.id = pm.id_maquina
                    WHERE pm.id_proposta = :id";

                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':id', $idProposta, PDO::PARAM_INT);
                    $stmt->execute();

                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getMaxId($table) {

            $pdo = parent::getInstance();
        
            $sql = "SELECT MAX(id) AS max_id FROM $table";

            $statement = $pdo->query($sql);
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            return $result['max_id'] ?? 0;

        }


         public function login($table, $login){
        $pdo = parent::getInstance();

        $sql = "SELECT * FROM $table
                WHERE login = :login
                LIMIT 1";

        $statement = $pdo->prepare($sql);

        $statement->bindValue(':login', $login, PDO::PARAM_STR);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
}



        public function insert($table,$data)
        {
            $pdo = parent::getInstance();
            $fields = implode(", ",array_keys($data));
            $values = ":".implode(", :",array_keys($data));
        
            $sql = "INSERT INTO $table($fields) VALUES($values)";

            $statement = $pdo->prepare($sql);
            foreach($data as $key => $value)
            {
                $statement->bindValue
                (":$key",$value,PDO::PARAM_STR);
            }
            $statement->execute(); 

        }

        public function copyMaquina($idProposta, $idContrato)
            {
                $pdo = parent::getInstance();

                $sql = "
                    INSERT INTO contrato_maquina (id_contrato, id_maquina)
                    SELECT :id_contrato, id_maquina
                    FROM proposta_maquina
                    WHERE id_proposta = :id_proposta
                ";

                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':id_contrato', $idContrato, PDO::PARAM_INT);
                $stmt->bindValue(':id_proposta', $idProposta, PDO::PARAM_INT);

                return $stmt->execute();
            }

        public function delete($table,$id)
        {
            $pdo = parent::getInstance();
            $sql = "DELETE FROM $table WHERE id = :id";
            $statement = $pdo->prepare($sql);
            $statement->bindValue(":id",$id);
            $statement->execute();
        }

        public function getInfo($table,$id)
        {
            $pdo = parent::getInstance();
            $sql = "SELECT * FROM $table WHERE id = :id";
            $statement = $pdo->prepare($sql);
            $statement->bindValue(":id",$id);
            $statement->execute();

            return $statement->fetchAll();
        }

        public function update($table,$data,$id)
        {
            $pdo = parent::getInstance();
            $new_values = "";
            foreach($data as $key => $value)
            {
                $new_values .= "$key=:$key, ";
            }
            $new_values = substr($new_values,0,-2);

            $sql = "UPDATE $table SET $new_values WHERE id = :id";
            $statement = $pdo->prepare($sql);
            foreach($data as $key => $value)
            {
                $statement->bindValue
                (":$key",$value,PDO::PARAM_STR);
            }
            $statement->bindValue(":id",$id);
            $statement->execute();
        }


        public function updateStatusMaquina($status, $idProposta) {
            $pdo = parent::getInstance();

            $sql = "UPDATE maquina 
                    SET status = :status 
                    WHERE id IN(
                        SELECT id_maquina
                        FROM proposta_maquina
                        WHERE id_proposta = :id_proposta
                    )";

            $statement = $pdo->prepare($sql);

            // Usa bindValue (permite passar null diretamente)
            $statement->bindValue(':status', $status, PDO::PARAM_STR);

            // Se o valor for null, define explicitamente o tipo
            $statement->bindValue(':id_proposta', $idProposta, is_null($idProposta) ? PDO::PARAM_NULL : PDO::PARAM_INT);
            return $statement->execute();
        }

        public function listMaquinas(){

            $pdo = parent::getInstance();

            $sql = "SELECT m.*,

                            p.id   AS proposta_id,
                            p.status AS proposta_status,

                            c.id   AS contrato_id,
                            c.status AS contrato_status,
                            c.data_fim

                    FROM maquina m

                    LEFT JOIN proposta_maquina pm 
                        ON pm.id_maquina = m.id

                    LEFT JOIN proposta p
                        ON p.id = pm.id_proposta
                        AND p.status IN ('aberta','enviada','aceita')

                    LEFT JOIN contrato_maquina cm
                        ON cm.id_maquina = m.id

                    LEFT JOIN contrato c
                        ON c.id = cm.id_contrato
                        AND c.status = 'ativo'

                    GROUP BY m.id";

            $statement = $pdo->query($sql);
            $statement->execute();

            return $statement->fetchAll();
            
        }

        public function cancelProposta($idProposta){
                $pdo = parent::getInstance();

                try {
                    $pdo->beginTransaction();

                    // Atualiza status da proposta
                    $sql1 = "UPDATE proposta 
                            SET status = 'rejeitada' 
                            WHERE id = :id_proposta";

                    $stmt1 = $pdo->prepare($sql1);
                    $stmt1->bindValue(":id_proposta", $idProposta, PDO::PARAM_INT);
                    $stmt1->execute();


                    //Atualiza máquinas (status + remove vínculo)
                    $sql2 = "UPDATE maquina 
                            SET status = 'disponível',
                                id_proposta = NULL
                            WHERE id IN (
                                SELECT id_maquina 
                                FROM proposta_maquina 
                                WHERE id_proposta = :id_proposta
                            )";

                    $stmt2 = $pdo->prepare($sql2);
                    $stmt2->bindValue(":id_proposta", $idProposta, PDO::PARAM_INT);
                    $stmt2->execute();


                    //  Remove da tabela unida
                    $sql3 = "DELETE FROM proposta_maquina 
                            WHERE id_proposta = :id_proposta";

                    $stmt3 = $pdo->prepare($sql3);
                    $stmt3->bindValue(":id_proposta", $idProposta, PDO::PARAM_INT);
                    $stmt3->execute();


                    $pdo->commit();

                    return true;

                } catch (Exception $e) {
                    $pdo->rollBack();
                    return false;
                }
        }



}

?>