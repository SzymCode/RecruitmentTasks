<?php

namespace App\Entity;

use App\Repository\SMSRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SMSRepository::class)]
class SMS
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $sender = null;

    #[ORM\Column(length: 255)]
    private ?string $receiver = null;

    #[ORM\Column(length: 255)]
    private ?string $receivedDate = null;

    #[ORM\Column(length: 255)]
    private ?string $subject = null;

    #[ORM\Column(length: 5000)]
    private ?string $content = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSender(): ?string
    {
        return $this->sender;
    }

    public function setSender(string $sender): static
    {
        $this->sender = $sender;

        return $this;
    }

    public function getReceiver(): ?string
    {
        return $this->receiver;
    }

    public function setReceiver(string $receiver): static
    {
        $this->receiver = $receiver;

        return $this;
    }

    public function getReceivedDate(): ?string
    {
        return $this->receivedDate;
    }

    public function setReceivedDate(?string $receivedDate): static
    {
        $this->receivedDate = $receivedDate;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): ?static
    {
        $this->subject = $subject;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): static
    {
        $this->content = $content;

        return $this;
    }
}
