<?php

namespace Entity;

class Ressource {
    /** @var int */
    private $id;

    /** @var string */
    private $titre;

    /** @var string */
    private $contenu;

    /** @var User */
    private $createur;

    

    /**
     * Get the value of createur
     */ 
    public function getCreateur()
    {
        return $this->createur;
    }

    /**
     * Set the value of createur
     *
     * @return  self
     */ 
    public function setCreateur($createur)
    {
        $this->createur = $createur;

        return $this;
    }

    /**
     * Get the value of contenu
     */ 
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set the value of contenu
     *
     * @return  self
     */ 
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get the value of titre
     */ 
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set the value of titre
     *
     * @return  self
     */ 
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}

