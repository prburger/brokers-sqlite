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
     * @ORM\OneToOne(targetEntity=Contact::class, cascade={"persist", "remove"})
     */
    private $contact;

    /**
     * @ORM\ManyToMany(targetEntity=Product::class, inversedBy="suppliers", cascade={"persist", "remove"})
     */
    private $products;

    /**
     * @ORM\ManyToMany(targetEntity=Message::class, inversedBy="suppliers", cascade={"persist", "remove"})
    */
    private $messages;

    /**
     * @ORM\ManyToMany(targetEntity=Note::class, inversedBy="suppliers", cascade={"persist", "remove"})
     */
    private $notes;

    /**
     * @ORM\ManyToMany(targetEntity=Broker::class, mappedBy="suppliers", cascade={"persist", "remove"})
     */
    private $brokers;

    public $supplierSelection;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $broker_id;
    
    public function __construct()
    {
        $this->setID(1);
        $this->setName("");
        $this->setContact(new Contact());
        $this->setDateAdded(new \DateTime());
        $this->setDateEdited(new \DateTime());
        $this->products = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->notes = new ArrayCollection();
        $this->brokers = new ArrayCollection();
    }

    public function setID($id)
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

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(Contact $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        $this->products->removeElement($product);
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
        }

        return $this;
    }

    public function removeBroker(Broker $broker): self
    {
        $this->brokers->removeElement($broker);
        return $this;
    }

    public function getBrokerId(): ?int
    {
        return $this->broker_id;
    }

    public function setBrokerId(?int $broker_id): self
    {
        $this->broker_id = $broker_id;

        return $this;
    }

}
