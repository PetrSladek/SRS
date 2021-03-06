<?php
/**
 * Date: 7.1.13
 * Time: 16:55
 * Author: Michal Májský
 */
namespace SRS\Model;
use Doctrine\ORM\Mapping as ORM;


/**
 * Entita databazove nastaveni
 * @ORM\Entity(repositoryClass="\SRS\Model\SettingsRepository")
 * @property string $item
 * @property string $value
 * @property string $description
 */
class Settings extends \SRS\Model\BaseEntity
{

    /**
     * @ORM\Column(unique=true)
     * @var string
     */
    protected $item;


    /**
     * @ORM\Column(nullable=true)
     * @var string
     *
     */
    protected $value;
    /**
     * @ORM\Column(nullable=true)
     * @var string
     */
    protected $description;


    public function __construct($item, $description = null, $value = null)
    {
        $this->item = $item;
        $this->value = $value;
        $this->description = $description;
    }


    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setItem($item)
    {
        $this->item = $item;
    }

    public function getItem()
    {
        return $this->item;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

}

/**
 * Doctrine Repozitar pro praci se settings
 *
 * Definuje get a set funkce umoznujici pristupovat k nastaveni podobne jako k asociativnimu poli
 */
class SettingsRepository extends \Doctrine\ORM\EntityRepository
{
    public $entity = '\SRS\Model\Settings';

    /**
     * Vrati rovnou zadanou hodnotu v konfigu
     * @param string $item
     * @throws SettingsException
     * @return $string
     */
    public function get($item)
    {
        $result = $this->_em->getRepository($this->entity)->findByItem($item);
        if ($result == null) throw new SettingsException("Položka {$item} v Settings není");
        $value = $result[0]->value;
        return $value;
    }

    /**
     * @param $item
     * @param $value
     * @throws SettingsException
     */
    public function set($item, $value)
    {
        $result = $this->_em->getRepository($this->entity)->findByItem($item);
        if ($result == null) throw new SettingsException("Položka {$item} v Settings není");
        $item = $result[0];
        $item->value = $value;
        $this->_em->flush();
    }

    public function toArray()
    {

        $result = $this->_em->getRepository($this->entity)->findAll();
        \Nette\Diagnostics\Debugger::dump($result);
        throw new \Nette\NotImplementedException();
        //TODO
    }
}

class SettingsException extends \Exception
{
}
