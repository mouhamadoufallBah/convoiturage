<?php

namespace Convoiturage\Convoiturage\Models;

class ImageModel extends Model
{
    protected int $id;
    protected string $chemin;
    protected int $id_user;

    public function __construct()
    {
        $class = str_replace(__NAMESPACE__ . '\\', '', __CLASS__);
        $this->table = strtolower(str_replace('Model', '', $class));
    }

    public function imageByUser($idUser)
    {

        return $this->requete("SELECT * FROM $this->table WHERE id_user = ? ORDER BY id DESC
        LIMIT 1", [$idUser])->fetch();
    }


    /**
     * Get the value of id_user
     */
    public function getId_user()
    {
        return $this->id_user;
    }

    /**
     * Set the value of id_user
     *
     * @return  self
     */
    public function setId_user($id_user)
    {
        $this->id_user = $id_user;

        return $this;
    }

    /**
     * Get the value of chemin
     */
    public function getChemin()
    {
        return $this->chemin;
    }

    /**
     * Set the value of chemin
     *
     * @return  self
     */
    public function setChemin($chemin)
    {
        $this->chemin = $chemin;

        return $this;
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
}
