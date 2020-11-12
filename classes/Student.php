<?php
/**
 * summary
 */
class Student
{
    public $id;
    public $name;
    public $email;
    public $mobile;
    /**
     * summary
     */
    private $conn;
    private $tbl_name;
    public function __construct($db_conn)
    {
        $this->conn = $db_conn;
        $this->tbl_name = 'students';
    }

    public function createStudent()
    {
        $query = "insert into ". $this->tbl_name ." (name, email, mobile) values (?, ?, ?)";
        $statement = $this->conn->prepare($query);
        $this->name = htmlspecialchars( strip_tags( $this->name ) );
        $this->email = htmlspecialchars( strip_tags( $this->email ) );
        $this->mobile = htmlspecialchars( strip_tags( $this->mobile ) );
        $statement->bind_param("sss", $this->name, $this->email, $this->mobile);
        if ( $statement->execute() ) {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getAllStudents()
    {
        $query = "select * from ". $this->tbl_name;
        $statement = $this->conn->prepare($query);
        $statement->execute();
        return $statement->get_result();
    }

    public function getStudent()
    {
        $query = "select * from ". $this->tbl_name ." where id = ?";
        $statement = $this->conn->prepare($query);
        $statement->bind_param("i", $this->id);
        $statement->execute();
        $data = $statement->get_result();
        return $data->fetch_assoc();
    }

    public function updateStudent()
    {
        $query = "update ". $this->tbl_name ." set name = ?, email = ?, mobile = ? where id = ?";
        $statement = $this->conn->prepare($query);
        $this->name = htmlspecialchars( strip_tags( $this->name ) );
        $this->email = htmlspecialchars( strip_tags( $this->email ) );
        $this->mobile = htmlspecialchars( strip_tags( $this->mobile ) );
        $this->id = htmlspecialchars( intval( $this->id) );
        $statement->bind_param('sssi', $this->name, $this->email, $this->mobile, $this->id);
        if($statement->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function deleteStudent()
    {
        $query = "delete from ". $this->tbl_name ." where id = ?";
        $statement = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $statement->bind_param('i', $this->id);
        if($statement->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}