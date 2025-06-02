<?php

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testId(): void
    {
        $user = new User();

        // Par défaut, l'ID est null
        $this->assertNull($user->getId());
    }

    public function testUsername(): void
    {
        $user = new User();

        // Définit un nom d'utilisateur
        $user->setUsername('test_user');
        $this->assertEquals('test_user', $user->getUsername());
        $this->assertEquals('test_user', $user->getUsername());
    }

    public function testEmail(): void
    {
        $user = new User();

        // Définit une adresse e-mail
        $user->setEmail('test@example.com');
        $this->assertEquals('test@example.com', $user->getEmail());
    }

    public function testShippingAddress(): void
    {
        $user = new User();

        // Définit une adresse de livraison
        $user->setShippingAddress('123 rue du lac');
        $this->assertEquals('123 rue du lac', $user->getShippingAddress());
    }

    public function testRoles(): void
    {
        $user = new User();

        // Par défaut, il n'y a que le rôle ROLE_USER
        $this->assertEquals(['ROLE_USER'], $user->getRoles());

        // Définit un rôle supplémentaire
        $user->setRoles(['ROLE_ADMIN']);
        $this->assertEquals(['ROLE_ADMIN', 'ROLE_USER'], $user->getRoles());
    }

    public function testPassword(): void
    {
        $user = new User();

        // Définit un mot de passe
        $user->setPassword('hashed_password');
        $this->assertEquals('hashed_password', $user->getPassword());
    }

    public function testIsVerified(): void
    {
        $user = new User();

        // Par défaut, l'utilisateur n'est pas vérifié
        $this->assertFalse($user->isVerified());

        // Définit que l'utilisateur est vérifié
        $user->setIsVerified(true);
        $this->assertTrue($user->isVerified());
    }

    public function testEmailVerificationToken(): void
    {
        $user = new User();

        // Par défaut, le jeton est null
        $this->assertNull($user->getEmailVerificationToken());

        // Définit un jeton de vérification
        $user->setEmailVerificationToken('verification_token');
        $this->assertEquals('verification_token', $user->getEmailVerificationToken());
    }

    public function testEraseCredentials(): void
    {
        $user = new User();

        // La méthode doit exister mais ne fait rien
        $user->eraseCredentials();
        $this->assertTrue(true); // Vérification pour éviter une erreur
    }
}