<?php

interface UserVerifier
{
    public function verify(string $nationalCode,string $phoneNumber):bool;
}
