<?php

namespace Slackiss\Bundle\BitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * CollocationPlu
 * @Vich\Uploadable
 * @ORM\Table(name="bit_collocation_plu")
 * @ORM\Entity(repositoryClass="Slackiss\Bundle\BitBundle\Entity\CollocationPluRepository")
 */
class CollocationPlu
{

    public function __construct()
    {
        $now = new \DateTime();
        $this->created = $now;
        $this->modified = $now;
        $this->status   = true;
        $this->enabled  = true;
        $this->remark   = '';
        $this->sequence = 0;
    }
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank(message="名称不能为空")
     * @Assert\Length(max=200,maxMessage="名称不能超过200个字")
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     * @Assert\NotBlank(message="地址不能为空")
     * @Assert\Length(max=2000,maxMessage="地址不能超过200个字")
     * @ORM\Column(name="url", type="string", length=2000)
     */
    private $url;

    /**
     * @var string
     * @Assert\NotBlank(message="价格不能为空")
     * @Assert\Length(max=9,maxMessage="地址不能超过5位数")
     * @ORM\Column(name="price", type="string", length=255)
     */
    private $price;

    /**
     * @ORM\Column(name="sequence",type="integer")
     */
    private $sequence;
    /**
     * @Assert\NotBlank(message="请上传图片")
     * @ORM\Column(name="image",type="string",length=255)
     */
    protected $image;

    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    /**
     * @Assert\File(
     *     maxSize="5M",
     *     mimeTypes={"image/png","image/jpeg","image/pjpeg",
     *                          "image/jpg","image/gif"}
     * )
     * @Vich\UploadableField(mapping="plu", fileNameProperty="image")
     *
     * @var File $image
     */
    private $attach;

    public function setAttach($attach)
    {
        $this->attach = $attach;
        if($attach){
            $this->image = $attach->getFileName();
        }
        return $this;
    }

    public function getAttach()
    {
        return $this->attach;
    }

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetimetz")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified", type="datetimetz")
     */
    private $modified;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;

    /**
     * @var string
     *
     * @ORM\Column(name="remark", type="text",nullable=true)
     */
    private $remark;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Member")
     * @ORM\JoinColumn(name="member_id",referencedColumnName="id")
     */
    private $member;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Collocation")
     * @ORM\JoinColumn(name="collocation_id",referencedColumnName="id")
     */
    private $collocation;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return CollocationPlu
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return CollocationPlu
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return CollocationPlu
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return CollocationPlu
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set modified
     *
     * @param \DateTime $modified
     * @return CollocationPlu
     */
    public function setModified($modified)
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * Get modified
     *
     * @return \DateTime
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return CollocationPlu
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return CollocationPlu
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set remark
     *
     * @param string $remark
     * @return CollocationPlu
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;

        return $this;
    }

    /**
     * Get remark
     *
     * @return string
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     * Set member
     *
     * @param \Slackiss\Bundle\BitBundle\Entity\Member $member
     * @return CollocationPlu
     */
    public function setMember(\Slackiss\Bundle\BitBundle\Entity\Member $member = null)
    {
        $this->member = $member;

        return $this;
    }

    /**
     * Get member
     *
     * @return \Slackiss\Bundle\BitBundle\Entity\Member
     */
    public function getMember()
    {
        return $this->member;
    }

    /**
     * Set collocation
     *
     * @param \Slackiss\Bundle\BitBundle\Entity\Collocation $collocation
     * @return CollocationPlu
     */
    public function setCollocation(\Slackiss\Bundle\BitBundle\Entity\Collocation $collocation = null)
    {
        $this->collocation = $collocation;

        return $this;
    }

    /**
     * Get collocation
     *
     * @return \Slackiss\Bundle\BitBundle\Entity\Collocation
     */
    public function getCollocation()
    {
        return $this->collocation;
    }

    /**
     * Set sequence
     *
     * @param integer $sequence
     * @return CollocationPlu
     */
    public function setSequence($sequence)
    {
        $this->sequence = $sequence;

        return $this;
    }

    /**
     * Get sequence
     *
     * @return integer 
     */
    public function getSequence()
    {
        return $this->sequence;
    }
}
