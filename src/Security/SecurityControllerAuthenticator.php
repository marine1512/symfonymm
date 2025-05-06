<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class SecurityControllerAuthenticator extends AbstractLoginFormAuthenticator
{
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * Cette méthode gère l’authentification (vérifie le login et mot de passe)
     */
    public function authenticate(Request $request): Passport
    {
        // Récupère les valeurs soumises depuis les champs du formulaire (par défaut `_username` et `_password`)
        $username = $request->request->get('username', ''); // Défaut : chaîne vide
        $password = $request->request->get('password', '');

        // Vérifiez que l'identifiant est fourni. Sinon, affichez un message d'erreur personnalisé (optionnel).
        if (empty($username)) {
            throw new CustomUserMessageAuthenticationException('Le nom d’utilisateur ne peut pas être vide.');
        }

        // Le "Passport" associe un utilisateur et les informations de son authentification
        return new Passport(
            new UserBadge($username),                 // Identification de l’utilisateur
            new PasswordCredentials($password)       // Vérification via le mot de passe
        );
    }

    /**
     * Définit l'URL de la page de connexion (appelée en cas de problème d'authentification ou pour afficher le formulaire)
     */
    protected function getLoginUrl(Request $request): string
    {
        // La route "app_login" doit être définie dans votre fichier security.yaml comme route pour la connexion
        return $this->urlGenerator->generate('app_login');
    }

    /**
     * En cas de succès d'authentification, redirige l'utilisateur en fonction de son rôle
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): RedirectResponse
    {
        // Récupère les rôles de l'utilisateur connecté
        $roles = $token->getRoleNames();

        // Si l'utilisateur est un administrateur, redirigez-le vers le tableau de bord admin
        if (in_array('ROLE_ADMIN', $roles, true)) {
            return new RedirectResponse($this->urlGenerator->generate('admin_dashboard'));
        }

        // Sinon, redirigez vers la page d'accueil
        return new RedirectResponse($this->urlGenerator->generate('home'));
    }
}