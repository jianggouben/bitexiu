<?php

namespace Slackiss\Bundle\BitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Collocation
 * @Vich\Uploadable
 * @ORM\Table(name="bit_collocation")
 * @ORM\Entity(repositoryClass="Slackiss\Bundle\BitBundle\Entity\CollocationRepository")
 */
class Collocation
{

    const STATE_DRAFT='draft';
    const STATE_PUBLISHED='published';
    const STATE_VERIFIED='verified';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->labels = new \Doctrine\Common\Collections\ArrayCollection();
        $this->pictures = new \Doctrine\Common\Collections\ArrayCollection();
        $this->plus = new \Doctrine\Common\Collections\ArrayCollection();
        $this->hot = false;
        $this->status = true;
        $this->enabled = true;
        $now = new \DateTime();
        $this->created = $now;
        $this->modified = $now;
        $this->remark = '';
        $this->state = self::STATE_DRAFT;
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
     * @Vich\UploadableField(mapping="collocation", fileNameProperty="image")
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
     * @var string
     * @Assert\NotBlank(message="价格不能为空")
     * @ORM\Column(name="price", type="string", length=255)
     */
    private $price;

    /**
     * @ORM\ManyToMany(targetEntity="Label")
     * @ORM\JoinTable(name="bit_collocation_labels",
     *     joinColumns={@ORM\JoinColumn(name="collocation_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="label_id", referencedColumnName="id")}
     * )
     */
    private $labels;

    /**
     * @var string
     *
     * @ORM\OneToMany(targetEntity="CollocationPicture",mappedBy="collocation")
     */
    private $pictures;

    /**
     * @var string
     *
     * @ORM\OneToMany(targetEntity="CollocationPlu",mappedBy="collocation")
     */
    private $plus;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text",nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Member")
     * @ORM\JoinColumn(name="member_id",referencedColumnName="id")
     */
    private $member;

    /**
     * @var boolean
     *
     * @ORM\Column(name="hot", type="boolean")
     */
    private $hot;

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
     * @ORM\Column(name="state", type="string", length=255)
     */
    private $state;


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
     * @return Collocation
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
     * Set price
     *
     * @param string $price
     * @return Collocation
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
     * Set labels
     *
     * @param string $labels
     * @return Collocation
     */
    public function setLabels($labels)
    {
        $this->labels = $labels;

        return $this;
    }

    /**
     * Get labels
     *
     * @return string
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * Set pictures
     *
     * @param string $pictures
     * @return Collocation
     */
    public function setPictures($pictures)
    {
        $this->pictures = $pictures;

        return $this;
    }

    /**
     * Get pictures
     *
     * @return string
     */
    public function getPictures()
    {
        return $this->pictures;
    }

    /**
     * Set plus
     *
     * @param string $plus
     * @return Collocation
     */
    public function setPlus($plus)
    {
        $this->plus = $plus;

        return $this;
    }

    /**
     * Get plus
     *
     * @return string
     */
    public function getPlus()
    {
        return $this->plus;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Collocation
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set member
     *
     * @param string $member
     * @return Collocation
     */
    public function setMember($member)
    {
        $this->member = $member;

        return $this;
    }

    /**
     * Get member
     *
     * @return string
     */
    public function getMember()
    {
        return $this->member;
    }

    /**
     * Set hot
     *
     * @param boolean $hot
     * @return Collocation
     */
    public function setHot($hot)
    {
        $this->hot = $hot;

        return $this;
    }

    /**
     * Get hot
     *
     * @return boolean
     */
    public function getHot()
    {
        return $this->hot;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Collocation
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
     * @return Collocation
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
     * @return Collocation
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
     * @return Collocation
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
     * @return Collocation
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
     * Set state
     *
     * @param string $state
     * @return Collocation
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Add labels
     *
     * @param \Slackiss\Bundle\BitBundle\Entity\Label $labels
     * @return Collocation
     */
    public function addLabel(\Slackiss\Bundle\BitBundle\Entity\Label $labels)
    {
        $this->labels[] = $labels;

        return $this;
    }

    /**
     * Remove labels
     *
     * @param \Slackiss\Bundle\BitBundle\Entity\Label $labels
     */
    public function removeLabel(\Slackiss\Bundle\BitBundle\Entity\Label $labels)
    {
        $this->labels->removeElement($labels);
    }

    /**
     * Add pictures
     *
     * @param \Slackiss\Bundle\BitBundle\Entity\CollocationPicture $pictures
     * @return Collocation
     */
    public function addPicture(\Slackiss\Bundle\BitBundle\Entity\CollocationPicture $pictures)
    {
        $this->pictures[] = $pictures;

        return $this;
    }

    /**
     * Remove pictures
     *
     * @param \Slackiss\Bundle\BitBundle\Entity\CollocationPicture $pictures
     */
    public function removePicture(\Slackiss\Bundle\BitBundle\Entity\CollocationPicture $pictures)
    {
        $this->pictures->removeElement($pictures);
    }

    /**
     * Add plus
     *
     * @param \Slackiss\Bundle\BitBundle\Entity\CollocationPlu $plus
     * @return Collocation
     */
    public function addPlus(\Slackiss\Bundle\BitBundle\Entity\CollocationPlu $plus)
    {
        $this->plus[] = $plus;

        return $this;
    }

    /**
     * Remove plus
     *
     * @param \Slackiss\Bundle\BitBundle\Entity\CollocationPlu $plus
     */
    public function removePlus(\Slackiss\Bundle\BitBundle\Entity\CollocationPlu $plus)
    {
        $this->plus->removeElement($plus);
    }
}
