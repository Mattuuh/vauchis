<?php

// app/Models/Organization.php
public function brands()
{
    return $this->belongsToMany(Brand::class);
}