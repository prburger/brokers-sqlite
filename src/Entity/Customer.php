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
     * @ORM\JoinColumn(nullable=false)
     */
    private $contact;

    /**
     * @ORM\ManyToMany(targetEntity=Note::class, mappedBy="customers", orphanRemoval=true)
     * @ORM\JoinColumn(nullable=false)
    */
    private $notes;

    /**
     * @ORM\ManyToMany(targetEntity=Product::class, mappedBy="customers")
     * @ORM\JoinColumn(nullable=false)
    */
    private $products;

    /**
     * @ORM\ManyToMany(targetEntity=Broker::class, inversedBy="customers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $broker;

    /**
     * @ORM\ManyToMany(targetEntity=Message::class, mappedBy="customers")
     * @ORM\JoinColumn(nullable=false)
    */
    private $messages;

    public function __construct()
    {
        $this->setId(0);
        $this->setDateAdded(new \DateTime());
        $this->setDateEdited(new \DateTime());
        $this->products = new ArrayCollection();
        $this->notes = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->setContact(new Contact());
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
            $note->setCustomer($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getCustomer() === $this) {
                $note->setCustomer(null);
            }
        }

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
            $product->setCustomer($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getCustomer() === $this) {
                $product->setCustomer(null);
            }
        }

        return $this;
    }

    public function getBroker(): ?Broker
    {
        return $this->broker;
    }

    public function setBroker(?Broker $broker): self
    {
        $this->broker = $broker;

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
            $message->setGetCustomer($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getGetCustomer() === $this) {
                $message->setGetCustomer(null);
            }
        }

        return $this;
    }
}
