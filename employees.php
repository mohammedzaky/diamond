<?php
class Employee
{
    // dbection
    private $db;
    // Table
    private $db_table = "employee";
    // Columns
    public $id;
    public $name;
    public $email;
    public $designation;
    public $created;
    public $result;


    // Db dbection
    public function __construct($db)
    {
        $this->db = $db;
    }

    // GET ALL
    public function getEmployees()
    {
        $sqlQuery = "SELECT id, name, email, designation, created FROM " . $this->db_table . "";
        $this->result = $this->db->query($sqlQuery);
        return $this->result;
    }

    // CREATE
    public function createEmployee()
    {
        // sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->designation = htmlspecialchars(strip_tags($this->designation));
        $this->created = htmlspecialchars(strip_tags($this->created));
        $sqlQuery = "INSERT INTO " . $this->db_table .
            " SET name = '" . $this->name . "',
             email = '" . $this->email . "',
             designation = '" . $this->designation . "',
             created = '" . $this->created . "'";

        $this->db->query($sqlQuery);

        if ($this->db->affected_rows > 0) {
            return true;
        }
        return false;
    }

    // UPDATE
    public function getSingleEmployee()
    {
        $sqlQuery = "SELECT id, name, email, designation, created FROM " . $this->db_table . " WHERE id = " . $this->id;
        $record = $this->db->query($sqlQuery);
        $dataRow = $record->fetch_assoc();
        if ($dataRow != 0) {
            $this->name = $dataRow['name'];
            $this->email = $dataRow['email'];
            $this->designation = $dataRow['designation'];
            $this->created = $dataRow['created'];
        }
    }

    // UPDATE
    public function updateEmployee()
    {
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->designation = htmlspecialchars(strip_tags($this->designation));
        $this->created = htmlspecialchars(strip_tags($this->created));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $sqlQuery = "UPDATE " . $this->db_table . " SET name = '" . $this->name . "',
                                                    email = '" . $this->email . "',
                                                    designation = '" . $this->designation .
            "',created = '" . $this->created . "' WHERE id = " . $this->id;

        $this->db->query($sqlQuery);
        if ($this->db->affected_rows > 0) {
            return true;
        }
        return false;
    }

    // DELETE
    function deleteEmployee()
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = " . $this->id;
        $this->db->query($sqlQuery);
        if ($this->db->affected_rows > 0) {
            return true;
        }
        return false;
    }

    function saveImage($data, $filename) {

        $base64_img_array = explode(':', $data);
    
        $img_info = explode(',', end($base64_img_array));
        $img_file_extension = '';
        if (!empty($img_info)) {
            switch ($img_info[0]) {
                case 'image/jpeg;base64':
                    $img_file_extension = 'jpeg';
                    break;
                case 'image/jpg;base64':
                    $img_file_extension = 'jpg';
                    break;
                case 'image/gif;base64':
                    $img_file_extension = 'gif';
                    break;
                case 'image/png;base64':
                    $img_file_extension = 'png';
                    break;
            }
        }
        $img_file_name = 'assets/images/' . $filename . '.' . $img_file_extension;    
        $img_file = file_put_contents($img_file_name, base64_decode($img_info[1]));
        echo $filename."======".$data;
        if ($img_file) {
            return $img_file_name;
        } else {
            return false;
        }
    }
    // // UPLOAD
    // function uploadImage()
    // {
    //     if (isset($_FILES['upload'])){
    //         try{
    //             $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = " . $this->id;
    //             $this->db->query($sqlQuery);

    //             $sqlQuery = "INSERT INTO `images` (`img_name`,`img_data`) VALUES (?,?)";
    //             $this->db->query($sqlQuery);

    //             $stmt->execute([$_FILES['upload']['name'],file_get_contents($_FILES['upload']['tmp_name'])]);
    //         }catch(Exception $ex){

    //         }
    //     }       
 
    // }
}
