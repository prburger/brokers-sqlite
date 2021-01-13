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
     * @ORM\Column(type="date", nullable=true)
     */
    private $DateSent;

    /**
     * @ORM\ManyToMany(targetEntity=Broker::class, inversedBy="messages", cascade={"persist", "remove"})
     */
    private $brokers;

    /**
     * @ORM\ManyToMany(targetEntity=Supplier::class, inversedBy="messages", cascade={"persist", "remove"})
     */
    private $suppliers;

    /**
     * @ORM\ManyToMany(targetEntity=Customer::class, inversedBy="messages", cascade={"persist", "remove"})
     */
    private $customers;

    public function __construct()
    {
        $this->setId(1);
        $this->setDateAdded(new \DateTime());
        $this->setDateEdited(new \DateTime());
        $this->setDateSent(new \DateTime());
        $this->brokers = new ArrayCollection();
        $this->suppliers = new ArrayCollection();
        $this->customers = new ArrayCollection();
    }

    public function setId(int $id)
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

    public function getDateSent(): ?\DateTimeInterface
    {
        return $this->DateSent;
    }

    public function setDateSent(?\DateTimeInterface $DateSent): self
    {
        $this->DateSent = $DateSent;

        return $this;
    }

    /**
     * @return Collection|Broker[]
     */
    public function setBrokers(ArrayCollection $brokers)
    {
        $this->brokers = $brokers;
    }

    public function getBrokers(): Collection
    {
        return $this->brokers;
    }

    public $brokerSelection;
    public $customerSelection;
    public $supplierSelection;
    
    public function addBroker(Broker $broker): self
    {
        if (!$this->brokers->contains($broker)) {
            $this->brokers[] = $broker;
        }

        return $this;
    }

    public function removeBroker(Broker $broker): self
    {
        $this->brokers->removeElement($broker);

        return $this;
    }

    /**
     * @return Collection|Supplier[]
     */
    public function getSuppliers(): Collection
    {
        return $this->suppliers;
    }

    public function addSupplier(Supplier $supplier): self
    {
        if (!$this->suppliers->contains($supplier)) {
            $this->suppliers[] = $supplier;
        }

        return $this;
    }

    public function removeSupplier(Supplier $supplier): self
    {
        $this->suppliers->removeElement($supplier);

        return $this;
    }

    /**
     * @return Collection|Customer[]
     */
    public function getCustomers(): Collection
    {
        return $this->customers;
    }

    public function addCustomer(Customer $customer): self
    {
        if (!$this->customers->contains($customer)) {
            $this->customers[] = $customer;
        }

        return $this;
    }

    public function removeCustomer(Customer $customer): self
    {
        $this->customers->removeElement($customer);

        return $this;
    }

}
