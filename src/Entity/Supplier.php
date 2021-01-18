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
     * @ORM\JoinColumn(nullable=false)
     */
    private $contact;

    /**
     * @ORM\ManyToMany(targetEntity=Product::class, mappedBy="suppliers")
     * @ORM\JoinColumn(nullable=true)
     */
    private $products;

    /**
     * @ORM\ManyToMany(targetEntity=Message::class, mappedBy="suppliers")
     * @ORM\JoinColumn(nullable=true)
    */
    private $messages;

    /**
     * @ORM\ManyToOne(targetEntity=Broker::class, inversedBy="suppliers")
     */
    private $broker;

    /**
     * @ORM\OneToMany(targetEntity=Note::class, mappedBy="supplier")
     */
    private $notes;

    public function __construct()
    {
        $this->setID(0);
        $this->setContact(new Contact());
        $this->setDateAdded(new \DateTime());
        $this->setDateEdited(new \DateTime());
        $this->products = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->notes = new ArrayCollection();
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
            $product->setSupplier($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getSupplier() === $this) {
                $product->setSupplier(null);
            }
        }

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
            $message->setSupplier($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getSupplier() === $this) {
                $message->setSupplier(null);
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
     * @return Collection|Supplier[]
     */
    public function getGetSuppliers(): Collection
    {
        return $this->getSuppliers;
    }

    public function addGetSupplier(Note $getSupplier): self
    {
        if (!$this->getSuppliers->contains($getSupplier)) {
            $this->getSuppliers[] = $getSupplier;
            $getSupplier->addSupplier($this);
        }

        return $this;
    }

    public function removeGetSupplier(Note $getSupplier): self
    {
        if ($this->getSuppliers->removeElement($getSupplier)) {
            $getSupplier->removeSupplier($this);
        }

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
            $note->setSupplier($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getSupplier() === $this) {
                $note->setSupplier(null);
            }
        }

        return $this;
    }

}
