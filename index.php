<?php

    class test {
        private $var1,$var2;
        public function set($var1,$var2) {
            $this->var1 = $var1;
            $this->var2 = $var2;
            $this->name = "empty";
            
        }
        public function get() {
            return array(
                "name"=>$this->name,
                "var1"=>$this->var1,
                "var2"=>$this->var2
            );
        }
        function __construct($var1,$var2) {
            $this->var1 = $var1;
            $this->var2 = $var2;
        }
    }

    class child extends test {
        public $name;  
       function __construct($var1,$var2) {
           parent::__construct($var1,$var2);
           $this->name = "child";
       }
    }

    class singleton {
        private static $instances = [];

        protected function __construct(){}

        public static function getInstance(): Singleton
        {
            $obj = static::class;
            if (!isset(self::$instances[$obj])) {
                self::$instances[$obj] = new static;
            }

            return self::$instances[$obj];
        }
    }

     $obj = new child(1,2);
     print_r($obj->get());



 define('USER', 'root');
 define('PASSWORD', '');
 define('HOST', 'localhost');
 define('DATABASE', 'test');
  
 try {
     $connection = new PDO("mysql:host=".HOST.";dbname=".DATABASE, USER, PASSWORD);
 } catch (PDOException $e) {
     exit("Error: " . $e->getMessage());
 }

session_start();
 
if (isset($_POST['login'])) {
 
    $username = $_POST['username'];
    $password = $_POST['password'];
 
    $query = $connection->prepare("SELECT * FROM users WHERE USERNAME=:username");
    $query->bindParam("username", $username, PDO::PARAM_STR);
    $query->execute();
 
    $result = $query->fetch(PDO::FETCH_ASSOC);
 
    if (!$result) {
        echo '<p class="error">Username password combination is wroweng!</p>';
    } else {
        // if (password_verify($password, $result['password'])) {
           $id = $_SESSION['user_id'] = $result['id'];
        //     echo '<p class="success">Congratulations, you are logged in!</p>';
        // } else {
        //     echo '<p class="error">Username password combination is wrong!</p>';
        // }

        $page = $_GET['page'];
        if ($page == "about")
        header("Refresh: 0; URL = about.html");
        else if ($page == "collection")
            header("Refresh: 0; URL = collection.html?id=$id");
        else 
        header("Refresh: 0; URL = landing.html?id=$id"); 
    }
}
 
 
?>


<form method="post" action="" name="signin-form">
    <div class="form-element">
        <label>Username</label>
        <input type="text" name="username"/>
    </div>
    <div class="form-element">
        <label>Password</label>
        <input type="password" name="password" required />
    </div>
    <button type="submit" name="login" value="login">Log In</button>
</form>