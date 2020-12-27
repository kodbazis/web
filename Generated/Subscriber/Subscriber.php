<?php

namespace Kodbazis\Generated\Subscriber;

use JsonSerializable;

class Subscriber implements JsonSerializable
{
    private $id;
private $email;
private $password;
private $isVerified;
private $verificationToken;
private $createdAt;


    
public function __construct($id, $email, $password, $isVerified, $verificationToken, $createdAt)
{
        $this->id = $id;
$this->email = $email;
$this->password = $password;
$this->isVerified = $isVerified;
$this->verificationToken = $verificationToken;
$this->createdAt = $createdAt;

}
    
    public function getId(): ?int
    {
        return $this->id;
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
    public function getCreatedAt(): ?int
    {
        return $this->createdAt;
    }
    
    
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
 'email' => $this->email,
 'password' => $this->password,
 'isVerified' => $this->isVerified,
 'verificationToken' => $this->verificationToken,
 'createdAt' => $this->createdAt,

        ];
    }
}
