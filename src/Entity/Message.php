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
     * @ORM\ManyToMany(targetEntity=Broker::class, inversedBy="getMessages")
     */
    private $sentToBrokers;

    /**
     * @ORM\ManyToMany(targetEntity=Supplier::class, inversedBy="getMessages")
     */
    private $sentToSuppliers;

    /**
     * @ORM\ManyToMany(targetEntity=Customer::class, inversedBy="getMessages")
     */
    private $sentToCustomers;

    /**
     * @ORM\ManyToMany(targetEntity=Broker::class, mappedBy="messages")
     */
    private $getMessages;

    public function __construct()
    {
        $this->sentToBrokers = new ArrayCollection();
        $this->sentToSuppliers = new ArrayCollection();
        $this->sentToCustomers = new ArrayCollection();
        $this->getMessages = new ArrayCollection();
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

    /**
     * @return Collection|Broker[]
     */
    public function getSentToBrokers(): Collection
    {
        return $this->sentToBrokers;
    }

    public function addSentToBrokers(Broker $sentTo): self
    {
        if (!$this->sentToBrokers->contains($sentTo)) {
            $this->sentToBrokers[] = $sentTo;
        }

        return $this;
    }

    public function removeSentToBrokers(Broker $sentTo): self
    {
        $this->sentToBrokers->removeElement($sentTo);

        return $this;
    }

    /**
     * @return Collection|Supplier[]
     */
    public function getSentToSuppliers(): Collection
    {
        return $this->sentToSuppliers;
    }

    public function addSentToSupplier(Supplier $sentToSupplier): self
    {
        if (!$this->sentToSuppliers->contains($sentToSupplier)) {
            $this->sentToSuppliers[] = $sentToSupplier;
        }

        return $this;
    }

    public function removeSentToSupplier(Supplier $sentToSupplier): self
    {
        $this->sentToSuppliers->removeElement($sentToSupplier);

        return $this;
    }

    /**
     * @return Collection|Customer[]
     */
    public function getSentToCustomers(): Collection
    {
        return $this->sentToCustomers;
    }

    public function addSentToCustomer(Customer $sentToCustomer): self
    {
        if (!$this->sentToCustomers->contains($sentToCustomer)) {
            $this->sentToCustomers[] = $sentToCustomer;
        }

        return $this;
    }

    public function removeSentToCustomer(Customer $sentToCustomer): self
    {
        $this->sentToCustomers->removeElement($sentToCustomer);

        return $this;
    }

    /**
     * @return Collection|Broker[]
     */
    public function getGetMessages(): Collection
    {
        return $this->getMessages;
    }

    public function addGetMessage(Broker $getMessage): self
    {
        if (!$this->getMessages->contains($getMessage)) {
            $this->getMessages[] = $getMessage;
            $getMessage->addMessage($this);
        }

        return $this;
    }

    public function removeGetMessage(Broker $getMessage): self
    {
        if ($this->getMessages->removeElement($getMessage)) {
            $getMessage->removeMessage($this);
        }

        return $this;
    }
}
