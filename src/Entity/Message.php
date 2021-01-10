<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 */
class Message
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\Column(type="date")
     */
    private $dateAdded;

    /**
     * @ORM\Column(type="date")
     */
    private $dateEdited;

    /**
     * @ORM\Column(type="string", length=120, nullable=true)
     */
    private $sentBy;

    /**
     * @ORM\ManyToOne(targetEntity=Broker::class, inversedBy="messages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $brokers;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="messages")
     */
    private $getCustomer;

    public function __construct()
    {
        $this->setDateAdded(new \DateTime());
        $this->setDateEdited(new \DateTime());
        $this->setDateSent(new \DateTime());
    }

    public function setId(string $id)
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

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

    public function getSentBy(): ?string
    {
        return $this->sentBy;
    }

    public function setSentBy(?string $sentBy): self
    {
        $this->sentBy = $sentBy;

        return $this;
    }

    public function setBrokers(Array $brokers )
    {
        $this->brokers = $brokers;
    }

    /**
     * @return Collection|Broker[]
     */
    public function getBrokers(): Collection
    {
        return $this->brokers;
    }

    public function addBroker(Broker $broker): self
    {
        if (!$this->brokers->contains($broker)) {
            $this->brokers[] = $broker;
            $broker->setMessage($this);
        }

        return $this;
    }

    public function removeBroker(Broker $broker): self
    {
        if ($this->brokers->removeElement($broker)) {
            // set the owning side to null (unless already changed)
            if ($broker->getMessage() === $this) {
                $broker->setMessage(null);
            }
        }

        return $this;
    }

    public function getGetCustomer(): ?Customer
    {
        return $this->getCustomer;
    }

    public function setGetCustomer(?Customer $getCustomer): self
    {
        $this->getCustomer = $getCustomer;

        return $this;
    }

}
