<?php 
namespace Convoiturage\Convoiturage\Models;

class UsersModel extends Model
{
    protected $id;
    protected $nomComplet;
    protected $tel;
    protected $email;
    protected $password;

    public function __construct()
    {
        $class = str_replace(__NAMESPACE__.'\\', '', __CLASS__);
        $this->table = strtolower(str_replace('Model', '', $class));
    }

    public function findUserByEmail(string $email)
    {
        return $this->requete("SELECT * FROM $this->table WHERE email = ?", [$email])->fetch();
    }

    public function findUserByTel(string $tel)
    {
        return $this->requete("SELECT * FROM $this->table WHERE tel = ?", [$tel])->fetch();
    }

    public function setSession()
    {
        $_SESSION['user'] = [
            'id' => $this->id,
            'email' => $this->email,
            'tel' => $this->tel,
            'nomComplet' => $this->nomComplet
        ];
    }


    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

	/**
	 * @return mixed
	 */
	public function getNomComplet() {
		return $this->nomComplet;
	}
	
	/**
	 * @param mixed $nomComplet 
	 * @return self
	 */
	public function setNomComplet($nomComplet): self {
		$this->nomComplet = $nomComplet;
		return $this;
	}

    /**
     * Get the value of tel
     */ 
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set the value of tel
     *
     * @return  self
     */ 
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }
}