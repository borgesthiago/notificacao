<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChamadoRepository")
 */
class Chamado
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $cliente;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $texto;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCliente(): ?int
    {
        return $this->cliente;
    }

    public function setCliente(int $cliente): self
    {
        $this->cliente = $cliente;

        return $this;
    }

    public function getTexto(): ?string
    {
        return $this->texto;
    }

    public function setTexto(string $texto): self
    {
        $this->texto = $texto;

        return $this;
    }
}
