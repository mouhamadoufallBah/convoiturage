<?php

namespace Convoiturage\Convoiturage\Controllers;

use Convoiturage\Convoiturage\Core\FormBuilder;
use Convoiturage\Convoiturage\Models\UsersModel;

class SecurityController extends Controller
{
    private $data;
    public function __construct()
    {
    }
    public function login()
    {
        $form = new FormBuilder();


        if (FormBuilder::validate($_POST, ['email', 'password'])) {
            $email = strip_tags($_POST['email']);

            $user = new UsersModel();
            $userArray = $user->findUserByEmail($email);

            if (!$userArray) {
                $_SESSION['erreur'] = "L'addresse mail ou mot de passe est incorecte";
                header('Location: /security/login');
                exit;
            }

            $user = $user->hydrate($userArray);

            if (password_verify($_POST['password'], $user->getPassword())) {
                $user->setSession();
                header('Location: /');
            } else {
                $_SESSION['erreur'] = "L'addresse mail ou mot de passe est incorecte";
                header('Location: /security/login');
                exit;
            }
        }


        $form->formStart()
            ->setLabelFor('email', 'Email')
            ->setInput('email', 'email', 'pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}"', 'title="Veuillez saisir un email valid"', ['id' => 'email', 'placeholder' => 'Veuillez entrer votre email', 'class' => 'form-control'])
            ->setLabelFor('password', 'password')
            ->setInput('password', 'password', 'pattern=".{8,}"', 'title="Mot de passe sécurisé avec minimum 8 caractères"', ['id' => 'password', 'placeholder' => 'Veuillez entrer votre mot de passe', 'class' => 'form-control'])
            ->setButton('Se connecter', ['class' => 'btn btn-primary mt-3'])
            ->formEnd();

        $this->render('security/login', ['loginForm' => $form->create()], 'default');
    }

    public function register()
    {
        $form = new FormBuilder();

        if (FormBuilder::validate($_POST, ['nom', 'prenom', 'email', 'telephone', 'password'])) {

            $nom = strip_tags($_POST['nom']);
            $prenom = strip_tags($_POST['prenom']);
            $email = strip_tags($_POST['email']);
            $telephone = strip_tags($_POST['telephone']);
            $password = password_hash($_POST['password'], PASSWORD_ARGON2I);


            $user = new UsersModel();

            $user->setNomComplet($prenom . '' . $nom)
                ->setEmail($email)
                ->setTel($telephone)
                ->setPassword($password);

            $user->create();

            $_SESSION['success'] = "Félicitations, votre inscription a été réussie ! Vous pouvez maintenant accéder à votre compte en utilisant vos identifiants.";
            header('Location: /security/login');
            exit;
        }

        $form->formStart()
            ->setLabelFor('nom', 'Nom')
            ->setInput('text', 'nom', 'pattern="[a-zA-Z]+"', 'title="Veuillez saisir que des lettre"', ['id' => 'nom', 'placeholder' => 'Veuillez entrer votre nom', 'class' => 'form-control'])
            ->setLabelFor('prenom', 'Prenom')
            ->setInput('text', 'prenom', 'pattern="[a-zA-Z]+"', 'title="Veuillez saisir que des lettre"', ['id' => 'prenom', 'placeholder' => 'Veuillez entrer votre prenom', 'class' => 'form-control'])
            ->setLabelFor('email', 'Email')
            ->setInput('email', 'email', 'pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}"', 'title="Veuillez saisir un email valid"', ['id' => 'email', 'placeholder' => 'Veuillez entrer votre email', 'class' => 'form-control'])
            ->setLabelFor('telephone', 'Telephone')
            ->setInput('text', 'telephone', 'pattern="(77|78|70|76)[0-9]{7}"', 'title="Veuillez saisir un numéro de téléphone valide commençant par 77, 78, 70 ou 76 et ayant 9 chiffres au total."', ['id' => 'telephone', 'placeholder' => 'Veuillez entrer votre numero de telephone', 'class' => 'form-control'])
            ->setLabelFor('password', 'password')
            ->setInput('password', 'password', 'pattern=".{8,}"', 'title="Mot de passe sécurisé avec minimum 8 caractères"', ['id' => 'password', 'placeholder' => 'Veuillez entrer votre mot de passe', 'class' => 'form-control'])
            ->setButton('S\'inscrire', ['class' => 'btn btn-primary mt-3'])
            ->formEnd();


        $this->render('security/register', ['registerForm' => $form->create()], 'default');
    }

    public function logout()
    {
        session_destroy();
        header('Location: /security/login'); 
    }
}
