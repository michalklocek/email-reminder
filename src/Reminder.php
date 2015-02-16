<?php

/**
 * Reminder
 *
 * @Table(name="reminders")
 * @Entity(repositoryClass="ReminderRepository")
 */
class Reminder
{
    /**
     * @var integer
     *
     * @Column(name="id", type="integer")
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @Column(name="message", type="string", length=255)
     */
    private $message;

    /**
     * @var \DateTime
     *
     * @Column(name="sendAt", type="datetime")
     */
    private $sendAt;

    /**
     * @var boolean
     *
     * @Column(name="sent", type="boolean")
     */
    private $sent = false;


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
     * Set message
     *
     * @param string $message
     * @return Reminder
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set sendAt
     *
     * @param \DateTime $sendAt
     * @return Reminder
     */
    public function setSendAt($sendAt)
    {
        $this->sendAt = $sendAt;

        return $this;
    }

    /**
     * Get sendAt
     *
     * @return \DateTime 
     */
    public function getSendAt()
    {
        return $this->sendAt;
    }

    /**
     * Set sent
     *
     * @param boolean $sent
     * @return Reminder
     */
    public function setSent($sent)
    {
        $this->sent = $sent;

        return $this;
    }

    /**
     * Get sent
     *
     * @return boolean 
     */
    public function getSent()
    {
        return $this->sent;
    }
}
