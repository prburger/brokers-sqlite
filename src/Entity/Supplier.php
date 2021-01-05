<?php

namespace App\Entity;

use App\Repository\SupplierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SupplierRepository::class)
 */
class Supplier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=120)
     */
    private $name;

    /**
     * @ORM\Column(type="date")
     */
    private $dateAdded;

    /**
     * @ORM\Column(type="date")
     */
    private $dateEdited;

    /**
     * @ORM\ManyToMany(targetEntity=Message::class, mappedBy="sentToSuppliers")
     */
    private $getMessages;

    /**
     * @ORM\ManyToOne(targetEntity=Broker::class, inversedBy="suppliers")
     */
    private $getBroker;

    public function __construct()
    {
        $this->getMessages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    /**
     * @return Collection|Message[]
     */
    public function getGetMessages(): Collection
    {
        return $this->getMessages;
    }

    public function addGetMessage(Message $getMessage): self
    {
        if (!$this->getMessages->contains($getMessage)) {
            $this->getMessages[] = $getMessage;
            $getMessage->addSentToSupplier($this);
        }

        return $this;
    }

    public function removeGetMessage(Message $getMessage): self
    {
        if ($this->getMessages->removeElement($getMessage)) {
            $getMessage->removeSentToSupplier($this);
        }

        return $this;
    }

    public function getGetBroker(): ?Broker
    {
        return $this->getBroker;
    }

    public function setGetBroker(?Broker $getBroker): self
    {
        $this->getBroker = $getBroker;

        return $this;
    }
}
