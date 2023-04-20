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
            if (FormBuilder::validate($_POST, ['id_voyage', 'id_passager'])) {

                $id_voyage = strip_tags($_POST['id_voyage']);
                $id_passager = strip_tags($_POST['id_passager']);
                $user = $_SESSION['user']['id'];

                $reservation = new ReservationModel();
                $reservation->setId_passager($id_passager)
                    ->setId_voyage($id_voyage);
                $reservation->create();

                $_SESSION['success'] = "Votre demande de reservation a été envoyée avec succées";
                header('Location: /main');
                exit;
            } else {
                $this->render('voyage/detail', compact('voyage'));
            }
        } else {
            $_SESSION['erreur'] = "Vous devez vous connecter pour pouvoir publier un trajet";
            header('Location: /security/login');
            exit;
        }
    }

    public function add()
    {

        if (isset($_SESSION['user']) && !empty($_SESSION['user']['id'])) {

            if (FormBuilder::validate($_POST, ['lieu_depart', 'lieu_arrive', 'date_depart', 'heure_depart', 'nbre_place', 'prix_place'])) {

                $lieu_depart = strip_tags($_POST['lieu_depart']);
                $lieu_arrive = strip_tags($_POST['lieu_arrive']);
                $date_depart = strip_tags($_POST['date_depart']);
                $heure_depart = strip_tags($_POST['heure_depart']);
                $nbre_place = strip_tags($_POST['nbre_place']);
                $prix_place = strip_tags($_POST['prix_place']);
                $user = $_SESSION['user']['id'];

                $voyage = new VoyageModel();

                $voyage->setLieu_depart($lieu_depart)
                    ->setLieu_arrive($lieu_arrive)
                    ->setDate_depart($date_depart)
                    ->setHeure_depart($heure_depart)
                    ->setNombre_place($nbre_place)
                    ->setPrix_place($prix_place)
                    ->setId_chauffeur($user);

                $voyage->create();

                $_SESSION['success'] = "Votre trajet a été publier avec succées";
                header('Location: /main');
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
                ->setButton('Publier', ['class' => 'btn btn-primary mt-3'])
                ->formEnd();

            $this->render('voyage/add', ['addForm' => $form->create()], 'default');
        } else {
            $_SESSION['erreur'] = "Vous devez vous connecter pour pouvoir publier un trajet";
            header('Location: /security/login');
            exit;
        }
    }

    public function mesPublications(int $id)
    {

        $voyageModel = new VoyageModel();
        $voyage = $voyageModel->findVoyageByChauffeur($id);

        $reservationModel = new reservationModel();

        $reservation = $reservationModel->findReservationByPassagere($_SESSION['user']['id']);

        if(FormBuilder::validate($_POST, ['id_Reservation', 'etat'])){
            $id_Reservation = strip_tags($_POST['id_Reservation']);
            $etat = strip_tags($_POST['etat']);

            $updateReservation = new ReservationModel();

            $updateReservation->setId($id_Reservation)
                            ->setEtat($etat);

            $updateReservation->update();

            header('Location: /main');
        }
        


        $this->render('voyage/trajet', compact('voyage', 'reservation'));
    }

//___________________________________________a enlever
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
