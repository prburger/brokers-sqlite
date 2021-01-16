<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
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
     * @ORM\ManyToMany(targetEntity=Note::class, mappedBy="products", orphanRemoval=true)
     * @ORM\JoinColumn(nullable=true)
     */
    private $notes;

    /**
     * @ORM\OneToOne(targetEntity=Specification::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $specifications;

    /**
     * @ORM\ManyToMany(targetEntity=Customer::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=true)
     */
    private $customers;

    /**
     * @ORM\ManyToMany(targetEntity=Supplier::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=true)
     */
    private $suppliers;

    /**
     * @ORM\Column(type="string", length=120, nullable=true)
     */
    private $customer_id;

        /**
     * @ORM\Column(type="string", length=120, nullable=true)
     */
    private $supplier_id;

    public function __construct()
    {
        $this->setId(1);
        $this->setDateAdded(new \DateTime());
        $this->setDateEdited(new \DateTime());
        $this->notes = new ArrayCollection();
        $this->specifications = new Specification();
    }

    public function setId(int $id)
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

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getSupplier(): ?Supplier
    {
        return $this->supplier;
    }

    public function setSupplier(?Supplier $supplier): self
    {
        $this->supplier = $supplier;

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
            $note->setProduct($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getProduct() === $this) {
                $note->setProduct(null);
            }
        }

        return $this;
    }

    public function getSpecifications(): ?Specification
    {
        return $this->specifications;
    }

    public function setSpecifications(Specification $specifications): self
    {
        $this->specifications = $specifications;

        return $this;
    }
}
