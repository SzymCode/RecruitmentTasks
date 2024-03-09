<?php

namespace App\Contracts;

interface NewsShouldReceiveFields
{
    public function getId(): int;
    public function getTitle(): string;
    public function getDescription(): string;
    public function getCreatedAt(): string;
    public function getUpdatedAt(): string;
}
