<?php
namespace Platinum\Database;
//分页辅助类
class PaginationHelper {

    public $total_item;
    public $current_page;
    public $total_page;
    public $skip;
    public $pre_page;

    const PRE_PAGE_MIN = 5;//TODO 20
    const PRE_PAGE_MAX = 100;

    public function __construct($page=1,$pre_page=PaginationHelper::PRE_PAGE_MIN,$total_item=0)
    {
        $this->current_page = (int)$page;
        $this->pre_page = (int)$pre_page;
        $this->total_item = (int)$total_item;
        $this->calculate();
    }

    public function setTotalItem($total_item){
        $this->total_item = (int)$total_item;
        $this->calculate();
    }

    public function calculate()
    {

        $this->pre_page = min($this->pre_page,self::PRE_PAGE_MAX);

        $this->total_page = ($this->total_item>0) ? ceil($this->total_item/$this->pre_page) : 0;

        //$this->current_page = min($this->current_page,$this->total_page);
        $this->current_page = max(1,$this->current_page);

        $this->skip = ($this->current_page-1) * $this->pre_page;
    }

    public function toArray()
    {
        return [
            'current_page' => $this->current_page,
            'pre_page' => $this->pre_page,
            'total_item' => $this->total_item,
            'total_page' => $this->total_page,
        ];
    }
}