<?php 
namespace Convoiturage\Convoiturage\Core;


class FormBuilder
{
    private $formCode = '';

    public function create()
    {
        return $this->formCode;
    }

    public static function validate(array $form, array $champs)
    {
        foreach($champs as $champ)
        {
            if(!isset($form[$champ]) || empty($form[$champ]))
            {
                return false;
            }
        }

        return true;
    }

    public function setAttributs(array $attributs): string
    {
        $str = '';

        $court = ['checked', 'disable', 'readonly', 'multiple', 'required', 'autofocus', 'nonvalidate', 'formnovalidate'];

        foreach($attributs as $attribut => $valeur)
        {
            $str = (in_array($attribut, $court) && $valeur == true) ? " $attribut" : " $attribut=\"$valeur\"";
        }

        return $str;
    }

    public function formStart(string $methode = 'post', string $action = '', array $attributs = []): self
    {
        $this->formCode .= "<form action = '$action' method = '$methode'";

        $this->formCode .= $attributs ? $this->setAttributs($attributs).'>' : '>';
       
        return $this;
    }

    public function formEnd(): self
    {
        $this->formCode .= '</form>';

        return $this;
    }

    public function setLabelFor(string $for, string $texte, array $attributs = []): self
    {
        $this->formCode .= "<label for='$for'";

        $this->formCode .= $attributs ? $this->setAttributs($attributs) : '';

        $this->formCode .= ">$texte</label>";

        return $this;
    }

    public function setInput(string $type, string $name, string $pattern, string $message, array $attributs = []): self
    {
        $this->formCode .= "<input type='$type' name='$name' $pattern $message";

        $this->formCode .= $attributs ? $this->setAttributs($attributs).'>' : '>';

        return $this;
    }

    public function setTextArrea(string $name, string $valeur = '', array $attributs = []): self
    {
        $this->formCode .= "<textarea name='$name'";

        $this->formCode .= $attributs ? $this->setAttributs($attributs) : '';

        $this->formCode .= ">$valeur</textarea>";

        return $this;
    }


    public function setSelect(string $name, array $options, array $attributs = []): self
    {
        $this->formCode .= "<select name='$name'";

        $this->formCode .= $attributs ? $this->setAttributs($attributs).'>' : '>';

        foreach($options as $valeur => $texte)
        {
            
            $this->formCode .= "<option value='$texte'>$texte</option>";
        }

        $this->formCode .= '</select>';

        return $this;
    }

    public function setButton(string $texte, array $attributs = []): self
    {
        $this->formCode .= "<button";
        
        $this->formCode .=$attributs ? $this->setAttributs($attributs) : '';

        $this->formCode .= ">$texte</button>";

        return $this;
    }

}