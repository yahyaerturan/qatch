<?php
class Migration_Create_v_cached extends CI_Migration {

  public function up()
  {
    /**
     * v_cached
     */
    $fields = array(
      'c_key'=>array('type'=>'VARCHAR','constraint'=>255),
      'c_val'=>array('type'=>'LONGTEXT','null'=>TRUE),
      'expires_at'=>array('type'=>'DATETIME','null'=>TRUE),
      'id_user'=>array('type'=>'BIGINT','constraint'=>20,'unsigned'=>TRUE,'null'=>TRUE)
    );
    $this->dbforge->add_field($fields);
    $this->dbforge->create_table('v_cached');

    $q = 'ALTER TABLE ' . 'v_cached' . ' ADD UNIQUE INDEX ' . 'c_key' . '_unique ('.'c_key'.');';
    $this->db->query($q);
  }

  public function down()
  {
    $this->dbforge->drop_table('v_cached',TRUE);
  }

}
