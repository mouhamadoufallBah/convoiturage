<?php

namespace Convoiturage\Convoiturage\Models;

class VoyageModel extends Model
{
    protected $id;
    protected $lieu_depart;
    protected $lieu_arrive;
    protected $date_depart;
    protected $heure_depart;
    protected $nombre_place;
    protected $prix_place;
    protected $id_chauffeur;


    public function __construct()
    {
        $class = str_replace(__NAMESPACE__ . '\\', '', __CLASS__);
        $this->table = strtolower(str_replace('Model', '', $class));
    }

    public function findVoyageByChauffeur($id_chauffeur)
    {
        return $this->requete("SELECT v.*, r.etat, r.id AS idReservation FROM $this->table AS v
                                JOIN reservation AS r ON v.id = r.id_voyage
                                WHERE id_chauffeur = ?", [$id_chauffeur])->fetchAll();
    }

    public function findVoyageByLieuDepartArrive($lieu_depart, $lieu_arrive, $date_depart, $heure_depart)
    {
        return $this->requete("SELECT v.id, v.lieu_depart, v.lieu_arrive, v.heure_depart, v.date_depart, v.prix_place, u.nomComplet FROM $this->table AS v
                                JOIN users AS u ON v.id_chauffeur = u.id
                                WHERE lieu_depart=? AND lieu_arrive=? AND date_depart=? AND heure_depart=?", [$lieu_depart, $lieu_arrive, $date_depart, $heure_depart])->fetchAll();
    }

    public function findVoyageByIdForDetail($id)
    {
        return $this->requete("SELECT v.id, v.lieu_depart, v.lieu_arrive, v.heure_depart, v.date_depart, v.prix_place, u.nomComplet FROM $this->table AS v
        JOIN users AS u ON v.id_chauffeur = u.id
        WHERE v.id=?", [$id])->fetch();
    }



    /**
     * Get the value of lieu_depart
     */
    public function getLieu_depart()
    {
        return $this->lieu_depart;
    }

    /**
     * Set the value of lieu_depart
     *
     * @return  self
     */
    public function setLieu_depart($lieu_depart)
    {
        $this->lieu_depart = $lieu_depart;

        return $this;
    }

    /**
     * Get the value of lieu_arrive
     */
    public function getLieu_arrive()
    {
        return $this->lieu_arrive;
    }

    /**
     * Set the value of lieu_arrive
     *
     * @return  self
     */
    public function setLieu_arrive($lieu_arrive)
    {
        $this->lieu_arrive = $lieu_arrive;

        return $this;
    }

    /**
     * Get the value of date_depart
     */
    public function getDate_depart()
    {
        return $this->date_depart;
    }

    /**
     * Set the value of date_depart
     *
     * @return  self
     */
    public function setDate_depart($date_depart)
    {
        $this->date_depart = $date_depart;

        return $this;
    }

    /**
     * Get the value of heure_depart
     */
    public function getHeure_depart()
    {
        return $this->heure_depart;
    }

    /**
     * Set the value of heure_depart
     *
     * @return  self
     */
    public function setHeure_depart($heure_depart)
    {
        $this->heure_depart = $heure_depart;

        return $this;
    }

    /**
     * Get the value of nombre_place
     */
    public function getNombre_place()
    {
        return $this->nombre_place;
    }

    /**
     * Set the value of nombre_place
     *
     * @return  self
     */
    public function setNombre_place($nombre_place)
    {
        $this->nombre_place = $nombre_place;

        return $this;
    }

    /**
     * Get the value of prix_place
     */
    public function getPrix_place()
    {
        return $this->prix_place;
    }

    /**
     * Set the value of prix_place
     *
     * @return  self
     */
    public function setPrix_place($prix_place)
    {
        $this->prix_place = $prix_place;

        return $this;
    }

    /**
     * Get the value of id_chauffeur
     */
    public function getId_chauffeur()
    {
        return $this->id_chauffeur;
    }

    /**
     * Set the value of id_chauffeur
     *
     * @return  self
     */
    public function setId_chauffeur($id_chauffeur)
    {
        $this->id_chauffeur = $id_chauffeur;

        return $this;
    }
}
