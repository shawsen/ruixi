<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
/**
 * 配置
 **/
class table_ruixi_setting extends discuz_table
{
	public function __construct() {
		$this->_table = 'ruixi_setting';
		$this->_pk = 'skey';
		parent::__construct();
	}

    // 获取全部配置
    public function getAllMap() {
        $map = array();
        $sql = 'SELECT skey,svalue FROM '.DB::table($this->_table);
        $res = DB::fetch_all($sql);
        foreach ($res as &$item) {
            $k = $item['skey'];
            $v = $item['svalue'];
            if ($k=='home_banner') $v=unserialize($v);
            $map[$k] = $v;
        }
        return $map;
    }

    // 获取配置
    public function fetch($skey, $auto_unserialize = false) {
        $sql = 'SELECT svalue FROM '.DB::table($this->_table).' WHERE '.DB::field($this->_pk, $skey);
        $data = DB::result_first($sql);
        return $auto_unserialize ? (array)unserialize($data) : $data;
    }

    // 更新配置
    public function update($skey, $svalue){
        return DB::insert($this->_table, array($this->_pk => $skey, 'svalue' => is_array($svalue) ? serialize($svalue) : $svalue), false, true);
    }
}

// vim600: sw=4 ts=4 fdm=marker syn=php
?>
