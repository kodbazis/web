<?php

namespace Kodbazis\Generated\Subscriber\Update;

use JsonSerializable;

class UpdatedSubscriber implements JsonSerializable
{
    private $email;
private $password;
private $isVerified;
private $verificationToken;


    
public function __construct($email, $password, $isVerified, $verificationToken)
{
        $this->email = $email;
$this->password = $password;
$this->isVerified = $isVerified;
$this->verificationToken = $verificationToken;

}
    
    public function getEmail(): ?string
    {
        return $this->email;
    }
    public function getPassword(): ?string
    {
        return $this->password;
    }
    public function getIsVerified(): ?bool
    {
        return $this->isVerified;
    }
    public function getVerificationToken(): ?string
    {
        return $this->verificationToken;
    }
    
    
    public function jsonSerialize()
    {
        return [
            'email' => $this->email,
 'password' => $this->password,
 'isVerified' => $this->isVerified,
 'verificationToken' => $this->verificationToken,

        ];
    }
}
