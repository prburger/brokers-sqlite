<?php

namespace App\Entity;

use App\Repository\BrokerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BrokerRepository::class)
 */
class Broker
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
     * @ORM\GeneratedValue
     */
    private $dateAdded;

    /**
     * @ORM\Column(type="date")
     * @ORM\GeneratedValue
     */
    private $dateEdited;

    /**
     * @ORM\ManyToMany(targetEntity=Message::class, cascade={"persist"})
     */
    private $messages;

    /**
     * @ORM\ManyToMany(targetEntity=Note::class, cascade={"persist"})
     */
    private $notes;

    /**
     * @ORM\ManyToMany(targetEntity=Customer::class, cascade={"persist"})
     */
    private $customers;

    /**
     * @ORM\ManyToMany(targetEntity=Supplier::class, cascade={"persist"})
     */
    private $suppliers;

    /**
     * @ORM\OneToOne(targetEntity=Contact::class, cascade={"persist","remove"})
     */
    private $contact;

    public function __construct()
    {
        $this->setDateAdded(new \DateTime());
        $this->setDateEdited(new \DateTime()); 
        
        $this->messages = new ArrayCollection();
        $this->notes = new ArrayCollection();
        $this->customers = new ArrayCollection();
        $this->suppliers = new ArrayCollection();
       // $this->contact = new Contact();
    }

    public function setContact(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function getContact(): Contact
    {
        return $this->contact;
    }
     
    
    public function setId($id)
    {
        $this->id = $id;
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
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        $this->messages->removeElement($message);

        return $this;
    }

    /**
     * @return Collection|Note[]
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        $this->notes->removeElement($note);

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

}
