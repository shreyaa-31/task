<?php

namespace App\Interfaces;
 

interface UserInterface
{
   
   public function register(array $data);
   public function edit($id);
   public function update(array $data);
}
