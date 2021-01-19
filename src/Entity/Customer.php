<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 */
class Customer
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
     * @ORM\JoinColumn(nullable=true)
     */
    private $contact;

    /**
     * @ORM\ManyToMany(targetEntity=Product::class, inversedBy="customers")
     * @ORM\JoinColumn(nullable=true)
    */
    private $products;

    /**
     * @ORM\ManyToMany(targetEntity=Broker::class, mappedBy="customers")
     * @ORM\JoinColumn(nullable=true)
     */
    private $brokers;

    /**
     * @ORM\ManyToMany(targetEntity=Message::class, inversedBy="customers")
     * @ORM\JoinColumn(nullable=true)
    */
    private $messages;

    /**
     * @ORM\ManyToMany(targetEntity=Note::class, inversedBy="customers")
     * @ORM\JoinColumn(nullable=true)
    */
    private $notes;

    /**
     * @ORM\ManyToMany(targetEntity=Supplier::class, mappedBy="suppliers")
     */
    private $suppliers;

    public function __construct()
    {
        $this->setId(1);
        $this->setContact(new Contact());
        $this->setDateAdded(new \DateTime());
        $this->setDateEdited(new \DateTime());
        $this->products = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->brokers = new ArrayCollection();        
        $this->notes = new ArrayCollection();
        $this->suppliers = new ArrayCollection();
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
