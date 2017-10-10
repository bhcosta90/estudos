<?php
namespace app\traits;

trait Data {
    /** @Column(type="string", length=11) **/
    protected $created_at;

    /** @Column(type="string", length=11, nullable=true) **/
    protected $update_at;

    /** @Column(type="string", length=11, nullable=true) **/
    protected $remove_at;

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
        return $this;
    }

    public function getUpdateAt()
    {
        return $this->update_at;
    }

    public function setUpdateAt($update_at)
    {
        $this->update_at = $update_at;
        return $this;
    }

    public function getRemoveAt()
    {
        return $this->remove_at;
    }

    public function setRemoveAt($remove_at)
    {
        $this->remove_at = $remove_at;
        return $this;
    }

}
?>
