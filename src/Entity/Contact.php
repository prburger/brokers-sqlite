<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContactRepository::class)
 */
class Contact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=120, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=120, nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    private $mobile;

    /**
     * @ORM\Column(type="string", length=120, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=120, nullable=true)
     */
    private $whatsapp;

    /**
     * @ORM\Column(type="string", length=120, nullable=true)
     */
    private $wechat;

    /**
     * @ORM\Column(type="string", length=120, nullable=true)
     */
    private $skype;

    /**
     * @ORM\Column(type="date")
     * @ORM\GeneratedValue
     */
    private $dateAdded;

    /**
     * @ORM\Column(type="date")
     * @ORM\GeneratedValue
     */
    private $dateEdited;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city=""): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country=""): self
    {
        $this->country = $country;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone=""): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(?string $mobile=""): self
    {
        $this->mobile = $mobile;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email=""): self
    {
        $this->email = $email;

        return $this;
    }

    public function getWhatsapp(): ?string
    {
        return $this->whatsapp;
    }

    public function setWhatsapp(?string $whatsapp=""): self
    {
        $this->whatsapp = $whatsapp;

        return $this;
    }

    public function getWechat(): ?string
    {
        return $this->wechat;
    }

    public function setWechat(?string $wechat=""): self
    {
        $this->wechat = $wechat;

        return $this;
    }

    public function getSkype(): ?string
    {
        return $this->skype;
    }

    public function setSkype(?string $skype=""): self
    {
        $this->skype = $skype;

        return $this;
    }

    public function getDateAdded(): ?\DateTimeInterface
    {
        return $this->dateAdded;
    }

    public function setDateAdded(\DateTimeInterface $dateAdded): self
    {
        $this->dateAdded = $dateAdded;

        return $this;
    }

    public function getDateEdited(): ?\DateTimeInterface
    {
        return $this->dateEdited;
    }

    public function setDateEdited(\DateTimeInterface $dateEdited): self
    {
        $this->dateEdited = $dateEdited;

        return $this;
    }
}
