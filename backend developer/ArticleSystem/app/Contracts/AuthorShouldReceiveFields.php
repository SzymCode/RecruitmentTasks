<?php

namespace App\Contracts;

interface AuthorShouldReceiveFields
{
    public function getId(): int;
    public function getName(): string;
    public function getCreatedAt(): string;
    public function getUpdatedAt(): string;
}
