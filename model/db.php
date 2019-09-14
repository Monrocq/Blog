<?php
class Db
{
   
    /**
     *
     * @var PDO
     */
    private static $_dbInstance;
    /**
     * Constructeur
     */
    protected function __construct()
    {
        if ( is_null(self::$_dbInstance) ) {
            self::$_dbInstance = new PDO('mysql:host=localhost;dbname=p5;charset=utf8', 'root', '');
        }
    }
    /**
     * Appel static au connecteur PDO
     * @return PDO
     */
    public static function getInstance() {        
        if ( is_null(self::$_dbInstance) ) {
            new Db();
        }
        return self::$_dbInstance;
    }

    public function query($query) {
        $requete = self::$_dbInstance->query($query);
        //$requete->closecuror();
        return $requete;
    }

    public function prepare($query) {
        $requete = self::$_dbInstance->prepare($query);
        return $requete;
    }

    public function execute($query) {
        $requete = self::$_dbInstance->execute($query);
        return $requete;
    }
}