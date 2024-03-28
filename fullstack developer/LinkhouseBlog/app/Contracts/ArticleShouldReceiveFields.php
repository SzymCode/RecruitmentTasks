<?php

namespace App\Contracts;


interface ArticleShouldReceiveFields
{
    public function getId(): int;
    public function getGuid(): string;
    public function getTitle(): string;
    public function getLink(): string;
    public function getDescription(): string;
    public function getCategory(): string;
    public function getPubDate(): string;
}
