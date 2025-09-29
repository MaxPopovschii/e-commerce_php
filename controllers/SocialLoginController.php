<?php

require_once __DIR__ . '/../models/SocialUser.php';

class SocialLoginController
{
    public function redirect($provider)
    {
        // Esempio: redirect a Google OAuth2
        if ($provider === 'google') {
            $client_id = 'GOOGLE_CLIENT_ID';
            $redirect_uri = 'http://localhost:8080/?page=sociallogin&action=callback&provider=google';
            $scope = 'email profile';
            $url = "https://accounts.google.com/o/oauth2/v2/auth?response_type=code&client_id=$client_id&redirect_uri=$redirect_uri&scope=$scope";
            header("Location: $url");
            exit;
        }
        // Puoi aggiungere altri provider (Facebook, GitHub, ecc.)
    }

    public function callback($provider)
    {
        // Esempio base per Google OAuth2 (devi gestire il token e la richiesta userinfo)
        if ($provider === 'google' && isset($_GET['code'])) {
            // Qui dovresti scambiare il code per il token e ottenere i dati utente
            // Per demo: login fittizio
            $_SESSION['user'] = [
                'username' => 'GoogleUser',
                'email' => 'user@gmail.com',
                'role' => 'user'
            ];
            header('Location: ?page=products');
            exit;
        }
        echo "Login social non riuscito.";
    }
}