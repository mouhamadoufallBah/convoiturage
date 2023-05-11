<?php

namespace Convoiturage\Convoiturage\Controllers;

use Convoiturage\Convoiturage\Core\FormBuilder;
use Convoiturage\Convoiturage\Models\ReservationModel;
use Convoiturage\Convoiturage\Models\VoyageModel;

class VoyageController extends Controller
{

    public function search()
    {
        $voyages = [];
        if (FormBuilder::validate($_POST, ['lieu_depart', 'lieu_arrive', 'date_depart', 'heure_depart'])) {

            $lieu_depart = strip_tags($_POST['lieu_depart']);
            $lieu_arrive = strip_tags($_POST['lieu_arrive']);
            $date_depart = strip_tags($_POST['date_depart']);
            $heure_depart = strip_tags($_POST['heure_depart']);

            $voyageModel = new VoyageModel();

            $voyages = $voyageModel->findVoyageByLieuDepartArrive($lieu_depart, $lieu_arrive, $date_depart, $heure_depart);
        }

        $this->render('voyage/search', compact('voyages'));
    }

    public function detail($id)
    {
        $voyageModel = new VoyageModel();
        $voyage = $voyageModel->findVoyageByIdForDetail($id);


        if (isset($_SESSION['user']) && !empty($_SESSION['user']['id'])) {
            if (FormBuilder::validate($_POST, ['id_voyage', 'id_passager', 'nombrePlace'])) {

                $id_voyage = strip_tags($_POST['id_voyage']);
                $id_passager = strip_tags($_POST['id_passager']);
                $nombrePlace = strip_tags($_POST['nombrePlace']);
                $user = $_SESSION['user']['id'];

                $reservation = new ReservationModel();
                $reservation->setId_passager($id_passager)
                    ->setId_voyage($id_voyage)
                    ->setPlaceReserver($nombrePlace);

                $reservation->create();



                $_SESSION['success'] = "Votre demande de reservation a été envoyée avec succées";
                header('Location: /main');
                exit;
            } else {
                $this->render('voyage/detail', compact('voyage'));
            }
        } else {
            $_SESSION['erreur'] = "Vous devez vous connecter pour reserver une voyage";
            header('Location: /security/login');
            exit;
        }
    }

    public function add()
    {

        if (isset($_SESSION['user']) && !empty($_SESSION['user']['id'])) {

            if (FormBuilder::validate($_POST, ['lieu_depart', 'lieu_arrive', 'date_depart', 'heure_depart', 'nbre_place', 'prix_place', 'description'])) {

                $lieu_depart = strip_tags($_POST['lieu_depart']);
                $lieu_arrive = strip_tags($_POST['lieu_arrive']);
                $date_depart = strip_tags($_POST['date_depart']);
                $heure_depart = strip_tags($_POST['heure_depart']);
                $nbre_place = strip_tags($_POST['nbre_place']);
                $prix_place = strip_tags($_POST['prix_place']);
                $description = strip_tags($_POST['description']);
                $user = $_SESSION['user']['id'];

                $voyage = new VoyageModel();

                $voyage->setLieu_depart($lieu_depart)
                    ->setLieu_arrive($lieu_arrive)
                    ->setDate_depart($date_depart)
                    ->setHeure_depart($heure_depart)
                    ->setNombre_place($nbre_place)
                    ->setPrix_place($prix_place)
                    ->setDescription($description)
                    ->setId_chauffeur($user);


                $voyage->create();

                $_SESSION['success'] = "Votre trajet a été publier avec succées";
                header('Location: /voyage/mesPublications/' . $_SESSION['user']['id']);
                exit;
            }

            $form = new FormBuilder();

            $form->formStart()
                ->setLabelFor('lieu_depart', 'Lieu de depart')
                ->setInput('text', 'lieu_depart', 'pattern="[a-zA-Z0-9]+"', 'title="Veuillez saisir le lieu de depart"', ['id' => 'lieu_depart', 'placeholder' => 'Veuillez entrer le lieu de depart', 'class' => 'form-control'])
                ->setLabelFor('lieu_arrive', 'Lieu d\'arrivée')
                ->setInput('text', 'lieu_arrive', 'pattern="[a-zA-Z0-9]+"', 'title="Veuillez saisir le lieu d\'arrivée"', ['id' => 'lieu_arrive', 'placeholder' => 'Veuillez entrer le lieu d\'arrivée', 'class' => 'form-control'])
                ->setLabelFor('date_depart', 'Date de depart')
                ->setInput('date', 'date_depart', 'pattern="[0-9]{2}-[0-9]{2}-[0-9]{4}"', 'title="Veuillez saisir la date de départ"', ['id' => 'date_depart', 'placeholder' => 'Veuillez entrer la date de départ', 'class' => 'form-control'])
                ->setLabelFor('heure_depart', 'Heure de depart')
                ->setInput('time', 'heure_depart', 'pattern="[0-9]{2}:[0-9]{2}"', 'title="Veuillez saisir l\'heure de départ."', ['id' => 'heure_depart', 'placeholder' => 'Veuillez entrer votre numero de telephone', 'class' => 'form-control'])
                ->setLabelFor('nbre_place', 'Nombre de places')
                ->setInput('number', 'nbre_place', 'pattern="^[1-4]+$" min="1" max="4"', 'title="Veuillez entrer le nombre de place"', ['id' => 'nbre_place', 'placeholder' => 'Veuillez entrer le nombre de place', 'class' => 'form-control'])
                ->setLabelFor('prix_place', 'Prix par place')
                ->setInput('text', 'prix_place', 'pattern="[0-9]+"', 'title="Veuillez saisir que des chiffre"', ['id' => 'prix_place', 'class' => 'form-control'])
                ->setLabelFor('description', 'description')
                ->setTextArrea('description', '', ['id' => 'description', 'class' => 'form-control'])
                ->setButton('Publier', ['class' => 'btn btn-primary mt-3'])
                ->formEnd();

            $this->render('voyage/add', ['addForm' => $form->create()]);
        } else {
            $_SESSION['erreur'] = "Vous devez vous connecter pour pouvoir publier un trajet";
            header('Location: /security/login');
            exit;
        }
    }

    public function mesPublications($id)
    {
        $voyageModel = new VoyageModel();
        $voyage = $voyageModel->findPublication($id);

        $reservationModel = new reservationModel();
        $reservation = $reservationModel->findReservationByPassagere($_SESSION['user']['id']);


        if (FormBuilder::validate($_POST, ['id_Reservation', 'etat'])) {
            $id_Reservation = strip_tags($_POST['id_Reservation']);
            $etat = strip_tags($_POST['etat']);

            $updateReservation = new ReservationModel();
            $updateVoyage = new VoyageModel();

            if ($etat == "En attente") {
                //recuperer le nombre de place reserver
                $currentReservation = $updateReservation->findById($id_Reservation);
                $placeReserver =  $currentReservation->placeReserver;
                //recuperer le nombre de place dispo
                $voyageId = $currentReservation->id_voyage;
                $currentVoyage = $updateVoyage->findById($voyageId);
                $placeDispo = $currentVoyage->nombre_place;
                //caluler le nombre de place restante
                $placeRestante = $placeDispo - $placeReserver;

                //Changer l'etat de la reservation
                $updateReservation->setId($id_Reservation)
                    ->setEtat("Valider");
                $updateReservation->update();

                //update nombre de place dispo dans le table voyage            
                $updateVoyage->setId($voyageId)
                    ->setNombre_place($placeRestante);
                $updateVoyage->update();
            } else {
                //recuperer le nombre de place reserver
                $currentReservation = $updateReservation->findById($id_Reservation);
                $placeReserver =  $currentReservation->placeReserver;
                //recuperer le nombre de place dispo
                $voyageId = $currentReservation->id_voyage;
                $currentVoyage = $updateVoyage->findById($voyageId);
                $placeDispo = $currentVoyage->nombre_place;
                //caluler le nombre de place restante
                $placeRestante = $placeDispo + $placeReserver;

                //Changer l'etat de la reservation
                $updateReservation->setId($id_Reservation)
                    ->setEtat("En attente");
                $updateReservation->update();

                //update nombre de place dispo dans le table voyage            
                $updateVoyage->setId($voyageId)
                    ->setNombre_place($placeRestante);
                $updateVoyage->update();
            }

            header('Location: /voyage/mesPublications/' . $_SESSION['user']['id']);
        }



        $this->render('voyage/mesPublications', compact('voyage', 'reservation'));
    }

    public function modifier($id)
    {

        if (isset($_SESSION['user']) && !empty($_SESSION['user']['id'])) {

            $voyageModel = new VoyageModel();
            $voyage = $voyageModel->findById($id);

            if (!$voyage) {
                http_response_code('404');
                $_SESSION['erreur'] = "Il n'y a pas de publication qui corresponde à cette id";
                header('Location: /voyage/mesPublications/' . $_SESSION['user']['id']);
                exit;
            }

            if ($voyage->id_chauffeur !== $_SESSION['user']['id']) {
                $_SESSION['erreur'] = "Vous n'avez pas accées à cette page";
                header('Location: /voyage/mesPublications/' . $_SESSION['user']['id']);
                exit;
            }

            if (FormBuilder::validate($_POST, ['lieu_depart', 'lieu_arrive', 'date_depart', 'heure_depart', 'nbre_place', 'prix_place', 'description'])) {

                $lieu_depart = strip_tags($_POST['lieu_depart']);
                $lieu_arrive = strip_tags($_POST['lieu_arrive']);
                $date_depart = strip_tags($_POST['date_depart']);
                $heure_depart = strip_tags($_POST['heure_depart']);
                $nbre_place = strip_tags($_POST['nbre_place']);
                $prix_place = strip_tags($_POST['prix_place']);
                $description = strip_tags($_POST['description']);


                $updateVoyage = new VoyageModel();

                $updateVoyage->setId($voyage->id)
                    ->setLieu_depart($lieu_depart)
                    ->setLieu_arrive($lieu_arrive)
                    ->setDate_depart($date_depart)
                    ->setHeure_depart($heure_depart)
                    ->setNombre_place($nbre_place)
                    ->setPrix_place($prix_place)
                    ->setDescription($description);
                $updateVoyage->update();

                $_SESSION['success'] = "Trajet modifier avec succée";
                header('Location: /voyage/mesPublications/' . $_SESSION['user']['id']);
            }


            $form = new FormBuilder();

            $form->formStart()
                ->setLabelFor('lieu_depart', 'Lieu de depart')
                ->setInput('text', 'lieu_depart', 'pattern="[a-zA-Z0-9]+"', 'title="Veuillez saisir le lieu de depart"value="' . $voyage->lieu_depart . '"', ['id' => 'lieu_depart', 'placeholder' => 'Veuillez entrer le lieu de depart', 'class' => 'form-control'])
                ->setLabelFor('lieu_arrive', 'Lieu d\'arrivée')
                ->setInput('text', 'lieu_arrive', 'pattern="[a-zA-Z0-9]+"', 'title="Veuillez saisir le lieu d\'arrivée"value="' . $voyage->lieu_arrive . '"', ['id' => 'lieu_arrive', 'placeholder' => 'Veuillez entrer le lieu d\'arrivée', 'class' => 'form-control'])
                ->setLabelFor('date_depart', 'Date de depart')
                ->setInput('date', 'date_depart', 'pattern="[0-9]{2}-[0-9]{2}-[0-9]{4}"', 'title="Veuillez saisir la date de départ"value="' . $voyage->date_depart . '"', ['id' => 'date_depart', 'placeholder' => 'Veuillez entrer la date de départ', 'class' => 'form-control'])
                ->setLabelFor('heure_depart', 'Heure de depart')
                ->setInput('time', 'heure_depart', 'pattern="[0-9]{2}:[0-9]{2}"', 'title="Veuillez saisir l\'heure de départ."value="' . $voyage->heure_depart . '"', ['id' => 'heure_depart', 'placeholder' => 'Veuillez entrer votre numero de telephone', 'class' => 'form-control'])
                ->setLabelFor('nbre_place', 'Nombre de places')
                ->setInput('number', 'nbre_place', 'pattern="^[1-4]+$" min="1" max="4"', 'title="Veuillez entrer le nombre de place"value="' . $voyage->nombre_place . '"', ['id' => 'nbre_place', 'placeholder' => 'Veuillez entrer le nombre de place', 'class' => 'form-control'])
                ->setLabelFor('prix_place', 'Prix par place')
                ->setInput('text', 'prix_place', 'pattern="[0-9]+"', 'title="Veuillez saisir que des chiffre" value="' . $voyage->prix_place . '"', ['id' => 'prix_place', 'class' => 'form-control'])
                ->setLabelFor('description', 'description')
                ->setTextArrea('description', $voyage->description, ['id' => 'description', 'class' => 'form-control'])
                ->setButton('Modifier', ['class' => 'btn btn-primary mt-3'])
                ->formEnd();


            return $this->render('voyage/modifier', ['updateForm' => $form->create()]);
        } else {
            $_SESSION['erreur'] = "Vous devez vous connecter pour pouvoir publier un trajet";
            header('Location: /voyage/mesPublications/' . $_SESSION['user']['id']);
            exit;
        }
    }


    public function suprimer($id)
    {
        $voyageModel = new VoyageModel();

        $voyageModel->delete($id);

        $_SESSION['success'] = "Trajet supprimer avec succée";
        header('Location: /voyage/mesPublications/' . $_SESSION['user']['id']);
    }

    public function annuler($id)
    {
        $reservationModel = new ReservationModel();

        $reservationModel->delete($id);

        $_SESSION['success'] = "Reservation annulée avec succée";
        header('Location: /voyage/mesPublications/' . $_SESSION['user']['id']);
    }

    

    //___________________________________________a enlever apres
    public function all()
    {

        if (isset($_SESSION['user']) && !empty($_SESSION['user']['id'])) {

            //envoyer une reservation
            if (FormBuilder::validate($_POST, ['id_voyage', 'id_passager'])) {

                $id_voyage = strip_tags($_POST['id_voyage']);
                $id_passager = strip_tags($_POST['id_passager']);
                $user = $_SESSION['user']['id'];

                $reservation = new ReservationModel();

                $reservation->setId_passager($id_passager)
                    ->setId_voyage($id_voyage);

                $reservation->create();

                $_SESSION['success'] = "Votre trajet a été publier avec succées";
                header('Location: /main');
                exit;
            }



            $voyageModel = new VoyageModel();
            $voyage = $voyageModel->findAll();


            $this->render('voyage/all', compact('voyage'), 'default');
        } else {
            $_SESSION['erreur'] = "Vous devez vous connecter pour pouvoir publier un trajet";
            header('Location: /security/login');
            exit;
        }
    }
}
