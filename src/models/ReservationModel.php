<?php

namespace Convoiturage\Convoiturage\Models;

class ReservationModel extends Model
{
    protected int $id;
    protected int $id_voyage;
    protected int $id_passager;
    protected string $etat;
    protected int $placeReserver;

    public function __construct()
    {
        $class = str_replace(__NAMESPACE__ . '\\', '', __CLASS__);
        $this->table = strtolower(str_replace('Model', '', $class));
    }


    public function findReservationByPassagere($id_passager)
    {
        return $this->requete(
            "SELECT r.*, u1.nomComplet AS passager, u2.nomComplet AS chauffeur, v.lieu_depart, v.lieu_arrive, v.date_depart,
                                v.heure_depart, v.prix_place
                                FROM $this->table as r
                                INNER JOIN users AS u1 ON r.id_passager = u1.id 
                                INNER JOIN voyage AS v ON r.id_voyage = v.id 
                                INNER JOIN users AS u2 ON v.id_chauffeur = u2.id
                                WHERE r.id_passager = (?)",
            [$id_passager]

        )->fetchAll();
    }

    public function findDemandeReservationByChauffeur($id_chauffeur)
    {
        return $this->requete(
            "SELECT COUNT(*) FROM $this->table AS r
                        INNER JOIN voyage AS v ON r.id_voyage = v.id
                        WHERE r.etat = 'En attente' AND v.id_chauffeur = ?",
            [$id_chauffeur],
        )->fetch();
    }

    /**
     * Get the value of id_passager
     */
    public function getId_passager()
    {
        return $this->id_passager;
    }

    /**
     * Set the value of id_passager
     *
     * @return  self
     */
    public function setId_passager($id_passager)
    {
        $this->id_passager = $id_passager;

        return $this;
    }

    /**
     * Get the value of id_voaye
     */
    public function getId_voyage()
    {
        return $this->id_voyage;
    }

    /**
     * Set the value of id_voaye
     *
     * @return  self
     */
    public function setId_voyage($id_voaye)
    {
        $this->id_voyage = $id_voaye;

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



    /**
     * Get the value of etat
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set the value of etat
     *
     * @return  self
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get the value of placeReserver
     */
    public function getPlaceReserver()
    {
        return $this->placeReserver;
    }

    /**
     * Set the value of placeReserver
     *
     * @return  self
     */
    public function setPlaceReserver($placeReserver)
    {
        $this->placeReserver = $placeReserver;

        return $this;
    }
}
